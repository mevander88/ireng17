<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\Bank;
use App\Models\User;
use App\Models\Saldo;
use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserDepositController extends Controller
{
    /**
     * 🔹 Halaman deposit user
     */
    public function index()
    {
        $saldos = (float) (Saldo::where('user_id', Auth::id())->value('saldo') ?? 0);

        try {
            $SG = new fiver();
            $balanceData = json_decode($SG->userbalance(Auth::user()->name));
            $apiBalance = data_get($balanceData, 'user.balance');

            if ($apiBalance !== null && is_numeric($apiBalance)) {
                $saldos = (float) $apiBalance;
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengambil saldo deposit dari API', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);
        }

        return view('account.deposit', [
            'saldos'   => $saldos,
            'bank'     => Bank::where('type', 1)->orderByRaw('status = 1 DESC')->orderBy('nama_bank')->get(),
            'ewallet'  => Bank::where('type', 2)->orderByRaw('status = 1 DESC')->orderBy('nama_bank')->get(),
            'setting'  => Setting::first(),
        ]);
    }

    /**
     * 🔹 Proses buat deposit baru (manual atau Jayapay)
     */
    public function store(Request $request)
{
    $setting = Setting::first();
    $paymentType = (int) $request->input('payment_type', $request->input('type', 1));

    $request->merge([
        'nominal' => (int) preg_replace('/\D+/', '', (string) $request->nominal),
        'payment_type' => $paymentType,
    ]);

    $request->validate([
        'payment_type' => 'required|in:1,2',
        'nominal' => 'required|integer|min:' . (int) ($setting->minimal_depo ?? 20000),
        'bank_id' => 'required_if:payment_type,1|nullable|exists:banks,id',
        'bukti_transfer' => 'required_if:payment_type,1|nullable|image|max:4096',
        'keterangan' => 'nullable|string|max:255',
    ], [
        'bank_id.required_if' => 'Pilih rekening tujuan untuk deposit manual.',
        'bukti_transfer.required_if' => 'Upload bukti transfer untuk deposit manual.',
        'bukti_transfer.image' => 'Bukti transfer harus berupa gambar.',
        'bukti_transfer.max' => 'Ukuran bukti transfer maksimal 4MB.',
    ]);

    $nominal = (int) $request->nominal;

    // Validasi minimal deposit
    if ($nominal < ($setting->minimal_depo ?? 20000)) {
        return back()->with('error', 'Minimal deposit adalah Rp ' . number_format($setting->minimal_depo, 0, ',', '.'));
    }

    if ((int) $request->payment_type === 1) {
        $bank = Bank::where('id', $request->bank_id)->where('status', 1)->first();
        if (!$bank) {
            return back()->withInput()->with('error', 'Metode transfer manual sedang tidak tersedia. Gunakan QRIS otomatis atau pilih rekening aktif lain.');
        }
    }

    // Cek transaksi pending
    $delayHours = $setting->deposit_delay ?? 24;
    $lastTrans = Transaksi::where('user_id', Auth::id())
        ->where('type', 1)
        ->where('status', 1) // Menunggu verifikasi (pending)
        ->latest()
        ->first();

    if ($lastTrans) {
        $hoursDiff = now()->diffInHours($lastTrans->created_at);
        if ($hoursDiff < $delayHours) {
            return back()->with('error', 'Masih ada transaksi deposit yang belum diproses. Mohon tunggu.');
        }

        // Tandai expired
        $lastTrans->update(['status' => 3]);
    }

    // Simpan transaksi baru (manual)
    $transaksi = new Transaksi();
    $transaksi->fill([
        'type'              => 1,
        'status'            => 1, // Status manual di-set ke 1 (pending)
        'trans_id'          => getTrx(),
        'bonus_id'          => null,
        'bonus_persentase'  => 0,
        'nominal'           => $nominal,
        'bank_id'           => (int) $request->payment_type === 1 ? $request->bank_id : null,
        'rek_pengirim'      => Auth::user()->bank . ' - ' . Auth::user()->no_rek,
        'keterangan'        => $request->keterangan ?? ((int) $request->payment_type === 2 ? 'Deposit otomatis QRIS' : 'Deposit manual'),
        'user_id'           => Auth::id(),
        'user_name'         => Auth::user()->name,
    ]);

    if ($request->hasFile('bukti_transfer')) {
        $transaksi->bukti_transfer = $request->file('bukti_transfer')->store('post-images');
    }

    $network = Network::where('user_id', Auth::id())->first();
    $transaksi->ref = $network->ref_code ?? null;
    $transaksi->save();

    // Jika transaksi menggunakan metode Jayapay
    if ((int) $request->payment_type === 2) {
        try {
            $jayapay = new \App\Services\JayapayService();

            $orderData = [
                'orderNum'       => $transaksi->trans_id,
                'amount'         => $transaksi->nominal,
                'name'           => Auth::user()->name,
                'email'          => Auth::user()->email ?? '-',
                'phone'          => Auth::user()->telp ?? Auth::user()->phone ?? '-',
                'productDetail'  => 'Deposit via Jayapay',
            ];

            $response = $jayapay->createOrder($orderData);
            Log::info('🧾 Jayapay createOrder response', $response);

            $payUrl = $response['qris_url']
                ?? $response['url']
                ?? data_get($response, 'response.url')
                ?? data_get($response, 'response.payUrl');

            if (!empty($payUrl)) {
                $transaksi->update([
                    'qris_url' => $payUrl,
                    'external_id' => $transaksi->trans_id,
                ]);

                return redirect()->away($payUrl);
            }

            $transaksi->update(['status' => 3, 'alasan' => $response['message'] ?? 'Gateway tidak mengembalikan URL pembayaran.']);
            return back()->with('error', $response['message'] ?? $response['msg'] ?? 'Gagal membuat transaksi QRIS otomatis.');
        } catch (\Throwable $e) {
            Log::error('💥 Jayapay error: ' . $e->getMessage());
            $transaksi->update(['status' => 3, 'alasan' => 'Kesalahan sistem gateway.']);
            return back()->with('error', 'Terjadi kesalahan pada sistem Jayapay.');
        }
    }

    return back()->with('success', 'Transaksi manual berhasil dibuat, menunggu verifikasi admin.');
}


    /**
     * 🔹 Callback dari Jayapay (notifikasi otomatis)
     */
    public function callback(Request $request)
{
    Log::info('🔔 Jayapay Callback diterima:', $request->all());

    try {
        $orderNum = $request->input('orderNum') ?? $request->input('merchantOrderNo') ?? $request->input('ref');
        $status   = strtoupper((string) ($request->input('status') ?? $request->input('platRespCode') ?? ''));
        $amount   = (int) $request->input('amount');

        $trx = Transaksi::where('trans_id', $orderNum)->first();
        if (!$trx) {
            Log::warning("⚠️ Transaksi Jayapay tidak ditemukan: {$orderNum}");
            return response('Order not found', 404);
        }

        if (in_array($status, ['SUCCESS', '1', '0000'], true)) {
            $user = User::find($trx->user_id);
            if (!$user) {
                Log::error("❌ User tidak ditemukan untuk transaksi {$orderNum}");
                return response('User not found', 404);
            }

            $SG = new fiver();
            $bonusTotal = $trx->bonus_id
                ? $trx->nominal + ($trx->nominal * $trx->bonus_persentase / 100)
                : $trx->nominal;

            Log::info("💰 Proses auto-approve deposit Jayapay untuk {$user->name}", [
                'trx_id' => $trx->id,
                'jumlah' => $bonusTotal
            ]);

            $depositResponse = json_decode($SG->deposit($user->name, $bonusTotal));
            Log::info("📨 Respon Fiver (deposit Jayapay):", (array)$depositResponse);

            if (in_array($depositResponse->status ?? null, [1, '1', 'success', 'SUCCESS'], true)) {
                // Tunggu saldo update di Fiver
                sleep(2);

                $balance = json_decode($SG->userbalance($user->name));
                $newBalance = $balance->user->balance ?? null;

                if ($newBalance !== null) {
                    // ✅ Update saldo lokal
                    Saldo::updateOrCreate(
                        ['user_id' => $user->id],
                        ['saldo' => $newBalance, 'bonus' => $bonusTotal]
                    );

                    // ✅ Update status transaksi
                    $trx->update([
                        'status'       => 2,
                        'approved_at'  => now(),
                        'approved_by'  => 'jayapay_auto',
                        'alasan'       => null,
                    ]);

                    // ✅ Catat ke tabel history
                    DB::table('history')->insert([
                        'user_id'     => $user->id,
                        'trans_id'    => $trx->trans_id,
                        'jumlah'      => $bonusTotal,
                        'type'        => '1',
                        'keterangan'  => 'Deposit otomatis via Jayapay',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    Log::info("✅ Jayapay Auto-Approve berhasil untuk {$user->name}");
                } else {
                    throw new \Exception('Tidak bisa mendapatkan saldo baru dari Fiver.');
                }
            } else {
                throw new \Exception('Deposit ke Fiver gagal dilakukan.');
            }
        } else {
            // ❌ Jika gagal atau expired
            $trx->update(['status' => 3]);
            Log::warning("❌ Pembayaran gagal atau dibatalkan untuk order {$orderNum}");
        }

        return response('OK', 200);

    } catch (\Throwable $e) {
        Log::error('💥 Jayapay Callback Error: ' . $e->getMessage());
        return response('Error', 500);
    }
}


    /**
     * 🔹 Admin: Approve / Reject deposit manual
     */
    public function action(string $id, Request $request)
{
    $trx = Transaksi::findOrFail($id);
    $user = User::findOrFail($trx->user_id);

    DB::beginTransaction();

    try {
        if ($request->status == 2) { // ✅ APPROVE (Deposit Manual)
            $SG = new fiver();
            $bonusTotal = $trx->bonus_id
                ? $trx->nominal + ($trx->nominal * $trx->bonus_persentase / 100)
                : $trx->nominal;

            Log::info('💰 Proses deposit manual ke Fiver', [
                'user' => $user->name,
                'jumlah' => $bonusTotal,
                'trx_id' => $trx->id
            ]);

            $res = json_decode($SG->deposit($user->name, $bonusTotal));
            Log::info('📨 Respon dari Fiver (deposit):', (array) $res);

            if (in_array($res->status ?? null, [1, '1', 'success', 'SUCCESS'], true)) {
                // Tunggu sebentar agar saldo benar-benar update di server Fiver
                sleep(2);

                $balanceRes = json_decode($SG->userbalance($user->name));
                Log::info('📊 Respon dari Fiver (saldo):', (array) $balanceRes);

                $newBalance = $balanceRes->user->balance ?? null;

                if ($newBalance !== null) {
                    // ✅ Update saldo lokal
                    Saldo::updateOrCreate(
                        ['user_id' => $user->id],
                        ['saldo' => $newBalance, 'bonus' => $bonusTotal]
                    );

                    // ✅ Update transaksi
                    $trx->update([
                        'status'       => 2,
                        'approved_at'  => now(),
                        'approved_by'  => Auth::id(),
                        'alasan'       => null,
                    ]);

                    // ✅ Simpan ke history
                    DB::table('history')->insert([
                        'user_id'     => $user->id,
                        'trans_id'    => $trx->trans_id,
                        'jumlah'      => $bonusTotal,
                        'type'        => '1',
                        'keterangan'  => 'Deposit manual disetujui',
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    Log::info("✅ Deposit manual berhasil untuk {$user->name}");
                } else {
                    throw new \Exception('Tidak bisa mendapatkan saldo baru dari Fiver.');
                }
            } else {
                throw new \Exception('Deposit ke Fiver gagal.');
            }

        } elseif ($request->status == 3) { // ❌ REJECT
            $trx->update([
                'status'      => 3,
                'alasan'      => $request->alasan,
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

            Log::warning("⚠️ Transaksi {$trx->id} ditolak oleh admin");
        }

        DB::commit();
        return back()->with('success', 'Status transaksi berhasil diperbarui.');

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('❌ Deposit Action Error: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
    }
}

}
