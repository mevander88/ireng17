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
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    protected $jayapay;

    public function __construct(JayapayService $jayapay)
    {
        $this->jayapay = $jayapay;
    }

    /**
     * 🧾 Membuat Pembayaran QRIS (Jayapay Cashier)
     */
    public function create(Request $request)
    {
        return $this->createPayment($request);
    }

    public function createPayment(Request $request)
    {
        try {
            $user = Auth::user();

            // Validasi input
            $request->validate([
                'nominal' => 'required|numeric|min:20000',
            ]);

            $amount = (int) $request->nominal;

            // orderNum unik
            $orderNum = 'JP' . time() . rand(100, 999);

            // URL redirect setelah selesai
            $returnUrl = url('/account/deposit?orderNum=' . $orderNum . '&status=success');

            $notifyUrl = config('jayapay.notify_url') ?: route('jayapay.callback');

            // Payload Jayapay
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

            Log::info("🔥 Kirim createOrder ke Jayapay", $data);

            // Kirim request Jayapay
            $response = $this->jayapay->createOrder($data);

            if (!$response['success']) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $response['message'] ?? 'Gagal membuat transaksi ke Jayapay',
                ], 500);
            }

            $result = $response['response'];

            // Jayapay mengirim "url" bukan "payUrl"
            $payUrl = $result['payUrl'] ?? $result['url'] ?? null;

            if (!$payUrl) {
                Log::error('❌ payUrl tidak diterima dari Jayapay', $result);
                return response()->json([
                    'status' => 'error',
                    'message' => 'payUrl tidak ditemukan dalam response Jayapay.',
                    'response' => $result,
                ], 500);
            }

            // Simpan transaksi PENDING
            Transaksi::create([
                'trans_id'  => $orderNum,
                'ref'       => $orderNum,
                'type'      => 1,
                'status'    => 1,
                'nominal'   => $amount,
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'created_at'=> now(),
            ]);

            Log::info("✅ Transaksi berhasil dibuat", [
                'orderNum' => $orderNum,
                'payUrl'   => $payUrl
            ]);

            return redirect()->away($payUrl);

        } catch (\Exception $e) {
            Log::error("❌ Error createPayment", [
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

    public function statusPayment(Request $request)
    {
        $orderNum = $request->query('orderNum') ?? $request->query('ref');

        if (!$orderNum && Auth::check()) {
            $latestPending = Transaksi::where('user_id', Auth::id())
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

        return response()->json(['info' => 'Pembayaran masih menunggu konfirmasi.']);
    }

    /**
     * 📩 Callback Jayapay (notifyUrl)
     */
    public function callback(Request $request)
    {
        Log::info('📩 Callback Jayapay diterima:', $request->all());

        try {
            $orderNum = $request->input('orderNum') ?? $request->input('merchantOrderNo') ?? $request->input('ref');
            $status   = strtoupper((string) ($request->input('status') ?? $request->input('platRespCode') ?? ''));
            $amount   = (int) $request->input('payMoney'); // pakai payMoney dari callback

            if (!$orderNum) {
                return response("Bad Request", 400);
            }

            $trx = Transaksi::where('ref', $orderNum)->first();

            if (!$trx) {
                return response("Order Not Found", 404);
            }

            // Jika sudah sukses → jangan double deposit
            if ($trx->status == 2) {
                return response("OK", 200);
            }

            // Jika pembayaran sukses
            if (in_array($status, ['SUCCESS', '1', '0000'], true)) {

                $user = User::find($trx->user_id);

                if (!$user) {
                    return response("User Not Found", 404);
                }

                // Total deposit (beserta bonus jika ada)
                $bonusTotal = $trx->bonus_id
                    ? $trx->nominal + ($trx->nominal * $trx->bonus_persentase / 100)
                    : $trx->nominal;

                // ===========================================
                // 🔥 FIX TERPENTING: Validasi respon Fiver
                // ===========================================

                $SG = new fiver();
                $depositRes = json_decode($SG->deposit($user->name, $bonusTotal));

                // Fiver return:
                // { "status": 1, "msg": "SUCCESS", ... }

                if (!isset($depositRes->status) || !in_array($depositRes->status, [1, '1', 'success', 'SUCCESS'], true)) {
                    Log::error("❌ Deposit ke Fiver gagal", (array) $depositRes);
                    return response("Fiver Error", 500);
                }

                // Delay 2 detik agar saldo Fiver update
                sleep(2);

                $balance = json_decode($SG->userbalance($user->name));
                $newBalance = $balance->user->balance ?? null;

                if ($newBalance === null) {
                    Log::error("❌ Tidak bisa mengambil saldo dari Fiver");
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
                    'approved_by' => 'jayapay_auto'
                ]);

                // History transaksi
                DB::table('history')->insert([
                    'user_id'    => $user->id,
                    'trans_id'   => $trx->trans_id,
                    'jumlah'     => $bonusTotal,
                    'type'       => 1,
                    'keterangan' => 'Deposit otomatis via Jayapay',
                    'created_at' => now(),
                ]);

                Log::info("✅ Deposit Jayapay sukses untuk {$user->name}");
            } else {

                // Jika gagal/expired
                $trx->update(['status' => 3]);
                Log::warning("❌ Pembayaran gagal / expired: $orderNum");
            }

            return response("OK", 200);

        } catch (\Throwable $e) {
            Log::error("💥 Callback Error: " . $e->getMessage());
            return response("Server Error", 500);
        }
    }
}
