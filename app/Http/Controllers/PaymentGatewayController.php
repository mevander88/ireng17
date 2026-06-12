<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\JayapayService;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Saldo;
use App\Http\Api\fiver;
use App\Services\ReferralCommissionService;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    private const TOPPAYMENT_SUCCESS_STATUSES = ['SUCCESS'];
    private const TOPPAYMENT_FAILED_STATUSES = ['PAY_CANCEL', 'PAY_ERROR'];

    protected $jayapay;

    public function __construct(JayapayService $jayapay)
    {
        $this->jayapay = $jayapay;
    }

    /**
     * ðŸ§¾ Membuat Pembayaran QRIS (TopPayment Cashier)
     */
    public function create(Request $request)
    {
        return $this->createPayment($request);
    }

    public function createPayment(Request $request)
    {
        try {
            $user = Auth::user();
            $setting = \App\Models\Setting::first() ?: new \App\Models\Setting([
                'minimal_depo' => 20000,
                'deposit_delay' => 24,
            ]);

            // Validasi input
            $request->validate([
                'nominal' => 'required|numeric|min:' . (int) ($setting->minimal_depo ?? 20000),
            ]);

            $amount = (int) $request->nominal;
            $pendingDeposit = Transaksi::activePendingDepositForUser($user->id, (int) ($setting->deposit_delay ?? 24))->latest()->first();
            if ($pendingDeposit) {
                return redirect()
                    ->to('/account/deposit')
                    ->with('error', 'Masih ada deposit pending. Selesaikan pembayaran sebelumnya sebelum membuat deposit baru.');
            }

            // orderNum unik
            $orderNum = 'JP' . time() . rand(100, 999);

            // URL redirect setelah selesai
            $returnUrl = url('/account/deposit?orderNum=' . $orderNum . '&status=success');

            $notifyUrl = config('jayapay.notify_url') ?: route('jayapay.callback');

            // Payload TopPayment
            $data = [
                'orderNum'      => $orderNum,
                'amount'        => $amount,
                'productDetail' => 'Deposit saldo #' . $user->id,
                'name'          => $user->name ?? 'Guest',
                'email'         => $user->email ?? 'guest@example.com',
                'phone'         => $user->telp ?? $user->phone ?? '081234567890',
                'method'        => 'QRIS',

                // WAJIB
                'notifyUrl'     => $notifyUrl,
                'returnUrl'     => $returnUrl,
            ];

            Log::info('TopPayment create order requested', [
                'order' => $orderNum,
                'amount' => $amount,
                'user_id' => $user->id,
            ]);

            // Kirim request TopPayment
            $response = $this->jayapay->createOrder($data);

            if (!$response['success']) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $response['message'] ?? 'Gagal membuat transaksi ke TopPayment',
                ], 500);
            }

            $result = $response['response'];
            $payUrl = $response['qris_url']
                ?? $response['url']
                ?? data_get($result, 'data.cashierUrl')
                ?? data_get($result, 'data.payData')
                ?? $result['payUrl']
                ?? $result['url']
                ?? null;

            if (!$payUrl) {
                Log::error('TopPayment payUrl missing', [
                    'order' => $orderNum,
                    'response_keys' => is_array($result) ? array_keys($result) : [],
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'URL pembayaran tidak ditemukan dalam response TopPayment.',
                ], 500);
            }

            // Simpan transaksi PENDING
            Transaksi::create([
                'trans_id'  => $orderNum,
                'ref'       => $orderNum,
                'type'      => 1,
                'status'    => 1,
                'nominal'   => $amount,
                'qris_url'  => $payUrl,
                'external_id' => $response['platform_order_num'] ?? data_get($result, 'data.platOrderNum') ?? $orderNum,
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'created_at'=> now(),
            ]);

            Log::info('Transaksi TopPayment berhasil dibuat', [
                'orderNum' => $orderNum,
                'has_pay_url' => true,
            ]);

            return redirect()->away($payUrl);

        } catch (\Exception $e) {
            Log::error("âŒ Error createPayment", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Sistem pembayaran sedang bermasalah. Silakan coba lagi beberapa saat.'
            ], 500);
        }
    }

    public function paymentQris(Request $request)
    {
        return view('content.payment', [
            'setting' => \App\Models\Setting::first(),
            'nominal' => (int) $request->query('nominal', 0),
            'payQRIS' => $request->query('payQRIS'),
            'response' => [],
        ]);
    }

    public function showQrcode(Request $request)
    {
        $encodedUrl = (string) $request->query('encodedUrl', '');
        $decodedUrl = base64_decode($encodedUrl, true);

        if ($decodedUrl === false || trim($decodedUrl) === '') {
            abort(400);
        }

        $decodedUrl = trim($decodedUrl);
        $allowedPrefixes = ['/payment', '/account/deposit', '/account/lastDirectTransfer'];
        $parts = parse_url($decodedUrl);
        $path = $parts['path'] ?? '';

        if (str_starts_with($decodedUrl, '/') && !str_starts_with($decodedUrl, '//')) {
            foreach ($allowedPrefixes as $prefix) {
                if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                    return redirect()->to($decodedUrl);
                }
            }
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = strtolower((string) ($parts['host'] ?? ''));
        $currentHost = strtolower((string) $request->getHost());

        if (in_array($scheme, ['http', 'https'], true) && $host === $currentHost) {
            foreach ($allowedPrefixes as $prefix) {
                if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                    return redirect()->to($decodedUrl);
                }
            }
        }

        abort(400);
    }

    public function statusPayment(Request $request)
    {
        $orderNum = $request->query('orderNum') ?? $request->query('ref');

        if (!$orderNum && Auth::check()) {
            $latestPending = Transaksi::where('user_id', Auth::id())
                ->where('type', 1)
                ->where('status', 1)
                ->latest()
                ->first();

            $orderNum = $latestPending->ref ?? $latestPending->trans_id ?? null;
        }

        if (!$orderNum) {
            return response()->json(['info' => 'Nomor transaksi tidak ditemukan.']);
        }

        $trx = Transaksi::where('ref', $orderNum)
            ->orWhere('trans_id', $orderNum)
            ->first();

        if (!$trx) {
            return response()->json(['info' => 'Transaksi belum ditemukan.']);
        }

        if ((int) $trx->status === 2) {
            return response()->json(['success' => 'Pembayaran berhasil.']);
        }

        if ((int) $trx->status === 3) {
            return response()->json(['info' => 'Pembayaran gagal atau kedaluwarsa.']);
        }

        $query = $this->jayapay->queryOrder($orderNum);
        if (($query['paid'] ?? false) === true) {
            $approved = $this->approvePaidDeposit($trx);
            if ($approved) {
                return response()->json(['success' => 'Pembayaran berhasil.']);
            }
        }

        if (($query['failed'] ?? false) === true) {
            $trx->update(['status' => 3, 'alasan' => 'TopPayment status: ' . ($query['status'] ?? 'PAY_ERROR')]);
            return response()->json(['info' => 'Pembayaran gagal atau kedaluwarsa.', 'gateway' => $query['status'] ?? null]);
        }

        return response()->json(['info' => 'Pembayaran masih menunggu konfirmasi.', 'gateway' => $query['status'] ?? null]);
    }

    /**
     * ðŸ“© Callback TopPayment (notifyUrl)
     */
    public function callback(Request $request)
    {
        Log::info('TopPayment callback received', [
            'orderNum' => $request->input('orderNum') ?? $request->input('merchantOrderNo') ?? $request->input('ref'),
            'status' => $request->input('status') ?? $request->input('platRespCode'),
            'has_sign' => $request->filled('sign'),
        ]);

        try {
            $orderNum = $request->input('orderNum') ?? $request->input('merchantOrderNo') ?? $request->input('ref');

            if (!$orderNum) {
                return response("Bad Request", 400);
            }

            if ($request->filled('sign') && !$this->jayapay->verifyCallback($request->all())) {
                Log::warning('TopPayment callback signature verification failed', [
                    'orderNum' => $orderNum,
                ]);

                return $this->handleUnverifiedCallbackByQuery($orderNum, $request);
            }

            $status   = strtoupper((string) ($request->input('status') ?? $request->input('platRespCode') ?? ''));
            $amount   = (int) ($request->input('amount') ?? $request->input('payMoney'));

            $trx = Transaksi::where('ref', $orderNum)
                ->orWhere('trans_id', $orderNum)
                ->first();

            if (!$trx) {
                return response("Order Not Found", 404);
            }

            if ($amount > 0 && $amount !== (int) $trx->nominal) {
                Log::warning('TopPayment callback amount mismatch', [
                    'orderNum' => $orderNum,
                    'callback_amount' => $amount,
                    'trx_amount' => (int) $trx->nominal,
                ]);

                return response("Bad Amount", 400);
            }

            // Jika sudah sukses â†’ jangan double deposit
            if ($trx->status == 2) {
                return response("SUCCESS", 200);
            }

            // Jika pembayaran sukses
            if (in_array($status, self::TOPPAYMENT_SUCCESS_STATUSES, true)) {

                $user = User::find($trx->user_id);

                if (!$user) {
                    return response("User Not Found", 404);
                }

                // Total deposit (beserta bonus jika ada)
                $bonusTotal = $trx->bonus_id
                    ? $trx->nominal + ($trx->nominal * $trx->bonus_persentase / 100)
                    : $trx->nominal;

                // ===========================================
                // ðŸ”¥ FIX TERPENTING: Validasi respon Fiver
                // ===========================================

                $SG = new fiver();
                $depositRes = json_decode($SG->deposit($user->name, $bonusTotal, $trx->trans_id));

                // Fiver return:
                // { "status": 1, "msg": "SUCCESS", ... }

                if (!isset($depositRes->status) || !in_array($depositRes->status, [1, '1', 'success', 'SUCCESS'], true)) {
                    Log::error("âŒ Deposit ke Fiver gagal", (array) $depositRes);
                    return response("Fiver Error", 500);
                }

                $balance = json_decode($SG->userbalance($user->name));
                $newBalance = $balance->user->balance ?? null;

                if ($newBalance === null) {
                    Log::error("âŒ Tidak bisa mengambil saldo dari Fiver");
                    return response("Balance Error", 500);
                }

                // Update saldo lokal
                Saldo::updateOrCreate(
                    ['user_id' => $user->id],
                    ['saldo' => $newBalance, 'bonus' => $bonusTotal]
                );

                // Update status transaksi
                $trx->update([
                    'status'      => 2,
                    'approved_at' => now(),
                    'approved_by' => 'jayapay_auto',
                    'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
                    'alasan' => null,
                ]);

                // History transaksi
                DB::table('history')->insert([
                    'user_id'    => $user->id,
                    'trans_id'   => $trx->trans_id,
                    'jumlah'     => $bonusTotal,
                    'type'       => 1,
                    'keterangan' => 'Deposit otomatis via TopPayment',
                    'created_at' => now(),
                ]);

                app(ReferralCommissionService::class)->creditForDeposit($trx->fresh());

                Log::info("âœ… Deposit TopPayment sukses untuk {$user->name}");
            } else {

                // Jika gagal/expired
                if (!in_array($status, self::TOPPAYMENT_FAILED_STATUSES, true)) {
                    $trx->update([
                        'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
                        'alasan' => $status ? 'TopPayment status: ' . $status : $trx->alasan,
                    ]);
                    Log::info('TopPayment callback pending status ignored', [
                        'orderNum' => $orderNum,
                        'status' => $status,
                    ]);

                    return response("SUCCESS", 200);
                }

                $trx->update([
                    'status' => 3,
                    'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
                    'alasan' => 'TopPayment status: ' . $status,
                ]);
                Log::warning("âŒ Pembayaran gagal / expired: $orderNum");
            }

            return response("SUCCESS", 200);

        } catch (\Throwable $e) {
            Log::error("ðŸ’¥ Callback Error: " . $e->getMessage());
            return response("Server Error", 500);
        }
    }

    private function approvePaidDeposit(Transaksi $trx): bool
    {
        if ((int) $trx->status === 2) {
            return true;
        }

        $user = User::find($trx->user_id);
        if (!$user) {
            return false;
        }

        $bonusTotal = $trx->bonus_id
            ? $trx->nominal + ($trx->nominal * $trx->bonus_persentase / 100)
            : $trx->nominal;

        $SG = new fiver();
        $depositRes = json_decode($SG->deposit($user->name, $bonusTotal, $trx->trans_id));

        if (!isset($depositRes->status) || !in_array($depositRes->status, [1, '1', 'success', 'SUCCESS'], true)) {
            $trx->update(['alasan' => $depositRes->msg ?? 'Deposit ke provider gagal.']);
            Log::error('Deposit ke provider gagal setelah payment paid', ['trx_id' => $trx->id, 'response' => (array) $depositRes]);
            return false;
        }

        $balance = json_decode($SG->userbalance($user->name));
        $newBalance = $balance->user->balance ?? null;
        if ($newBalance === null) {
            $trx->update(['alasan' => 'Saldo provider belum terbaca.']);
            return false;
        }

        Saldo::updateOrCreate(
            ['user_id' => $user->id],
            ['saldo' => $newBalance, 'bonus' => $bonusTotal]
        );

        $trx->update([
            'status' => 2,
            'approved_at' => now(),
            'approved_by' => 'top_payment_query',
            'alasan' => null,
        ]);

        DB::table('history')->insert([
            'user_id' => $user->id,
            'trans_id' => $trx->trans_id,
            'jumlah' => $bonusTotal,
            'type' => 1,
            'keterangan' => 'Deposit otomatis via TopPayment query',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        app(ReferralCommissionService::class)->creditForDeposit($trx->fresh());

        return true;
    }

    private function handleUnverifiedCallbackByQuery(string $orderNum, Request $request)
    {
        $trx = Transaksi::where('ref', $orderNum)
            ->orWhere('trans_id', $orderNum)
            ->first();

        if (!$trx) {
            return response("Order Not Found", 404);
        }

        if ((int) $trx->status === 2) {
            return response("SUCCESS", 200);
        }

        $query = $this->jayapay->queryOrder($orderNum);
        $gatewayStatus = $query['status'] ?? null;

        Log::info('TopPayment callback fallback query result', [
            'orderNum' => $orderNum,
            'gateway_status' => $gatewayStatus,
            'query_success' => $query['success'] ?? false,
            'paid' => $query['paid'] ?? false,
            'failed' => $query['failed'] ?? false,
        ]);

        if (($query['success'] ?? false) !== true) {
            return response("Query Error", 500);
        }

        if (($query['paid'] ?? false) === true) {
            $approved = $this->approvePaidDeposit($trx);
            if ($approved) {
                $trx->update([
                    'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
                    'alasan' => null,
                ]);

                return response("SUCCESS", 200);
            }

            return response("Provider Error", 500);
        }

        if (($query['failed'] ?? false) === true) {
            $trx->update([
                'status' => 3,
                'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
                'alasan' => 'TopPayment status: ' . ($gatewayStatus ?? 'PAY_ERROR'),
            ]);

            return response("SUCCESS", 200);
        }

        $trx->update([
            'external_id' => $request->input('platOrderNum') ?? $trx->external_id,
            'alasan' => $gatewayStatus ? 'TopPayment status: ' . $gatewayStatus : $trx->alasan,
        ]);

        return response("SUCCESS", 200);
    }
}
