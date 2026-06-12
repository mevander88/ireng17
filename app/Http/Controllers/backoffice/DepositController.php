<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Controllers\Controller;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\User;
use App\Services\ReferralCommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = Transaksi::with(['user', 'bonus'])
            ->where('type', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backoffice.deposit.deposit', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
            'type' => 'required|in:1,3',
            'rek_pengirim' => 'nullable|string|max:255',
            'bank_id' => 'nullable',
            'bonus_id' => 'nullable|exists:bonuses,id',
            'bonus_persentase' => 'nullable|numeric|min:0',
        ]);

        try {
            $transaksi = new Transaksi();
            $transaksi->user_id = auth()->user()->id;
            $transaksi->type = $request->type;
            $transaksi->nominal = $request->nominal;
            $transaksi->bank_id = $request->bank_id;
            $transaksi->trans_id = 'TRX' . time();
            $transaksi->rek_pengirim = $request->rek_pengirim ?? null;
            $transaksi->status = ($request->type == 3) ? 2 : 1;
            $transaksi->approved_by = ($request->type == 3) ? 'jayapay_auto' : null;
            $transaksi->keterangan = $request->keterangan ?? 'Deposit';
            $transaksi->bonus_id = $request->bonus_id ?? null;
            $transaksi->bonus_persentase = $request->bonus_persentase ?? null;
            $transaksi->save();

            if ($request->type == 3) {
                $this->processFiverDeposit($transaksi, 'jayapay_auto');
            }

            return back()->with('success', 'Deposit berhasil dibuat' . ($request->type == 3 ? ' (auto-approved)' : ', menunggu konfirmasi admin.'));
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan deposit: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan deposit.');
        }
    }

    public function confirm(string $id)
    {
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);

            if ($transaksi->type != 1) {
                return back()->with('error', 'Hanya deposit manual yang dapat disetujui.');
            }

            if ($transaksi->status != 1) {
                return back()->with('error', 'Transaksi sudah diproses.');
            }

            $transaksi->update([
                'status' => 2,
                'approved_at' => now(),
                'approved_by' => auth()->user()->name ?? 'Admin',
                'alasan' => null,
            ]);

            $this->processFiverDeposit($transaksi, auth()->user()->name ?? 'Admin');

            DB::commit();
            return back()->with('success', 'Deposit manual berhasil disetujui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal approve deposit manual: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyetujui deposit.');
        }
    }

    public function reject(Request $request, string $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            if ($transaksi->type != 1) {
                return back()->with('error', 'Hanya deposit manual yang dapat ditolak.');
            }

            if ($transaksi->status != 1) {
                return back()->with('error', 'Transaksi sudah diproses.');
            }

            $transaksi->update([
                'status' => 3,
                'alasan' => $request->alasan ?? 'Ditolak oleh admin',
                'approved_at' => now(),
                'approved_by' => auth()->user()->name ?? 'Admin',
            ]);

            return back()->with('success', 'Deposit berhasil ditolak.');
        } catch (\Throwable $e) {
            Log::error('Gagal reject deposit: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menolak deposit.');
        }
    }

    private function processFiverDeposit(Transaksi $transaksi, string $approvedBy)
    {
        try {
            $user = User::find($transaksi->user_id);
            if (!$user) {
                return false;
            }

            $provider = new fiver();
            $totalDeposit = $transaksi->bonus_id
                ? $transaksi->nominal + ($transaksi->nominal * $transaksi->bonus_persentase / 100)
                : $transaksi->nominal;

            $response = json_decode($provider->deposit($user->name, $totalDeposit, $transaksi->trans_id));
            Log::info("Deposit ke provider {$user->name}", (array) $response);

            if (in_array($response->status ?? null, [1, '1', 'success', 'SUCCESS'], true)) {
                $balanceData = json_decode($provider->userbalance($user->name));
                $saldoBaru = $balanceData->user->balance ?? 0;

                Saldo::updateOrCreate(
                    ['user_id' => $user->id],
                    ['saldo' => $saldoBaru, 'bonus' => $totalDeposit]
                );

                DB::table('history')->insert([
                    'user_id' => $user->id,
                    'trans_id' => $transaksi->trans_id,
                    'jumlah' => $totalDeposit,
                    'type' => 1,
                    'keterangan' => 'Deposit berhasil (' . $approvedBy . ')',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                app(ReferralCommissionService::class)->creditForDeposit($transaksi->fresh());

                Log::info("Deposit provider sukses untuk {$user->name}");
            } else {
                Log::error("Deposit provider gagal untuk {$user->name}", (array) $response);
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('processFiverDeposit Error: ' . $e->getMessage());
            return false;
        }
    }
}
