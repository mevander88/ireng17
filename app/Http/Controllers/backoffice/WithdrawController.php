<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Controllers\Controller;
use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $transaksi = Transaksi::query()
            ->where('type', 2)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('user_name', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhere('rek_pengirim', 'like', "%{$search}%")
                        ->orWhere('alasan', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('status = 1 DESC')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('backoffice.withdraw.withdraw', compact('transaksi', 'search'));
    }

    
    public function confirm(Request $request, string $id)
{
    $transaksi = Transaksi::where('user_id', $id)
        ->where('type', 2)
        ->where('status', 1)
        ->first();

    if (!$transaksi) {
        Log::error("Confirm withdraw gagal: transaksi tidak ditemukan", ['user_id' => $id]);
        return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
    }

    $transaksi->status = 2;
    $transaksi->alasan = 'Berhasil transfer ke rek ' . $transaksi->rek_pengirim;
    $transaksi->approved_at = now();
    $transaksi->approved_by = Auth::id();
    $transaksi->save();

    Log::info("Withdraw berhasil dikonfirmasi", [
        'transaksi_id' => $transaksi->id,
        'status' => $transaksi->status
    ]);

    return redirect()->back()->with('success', 'Withdraw berhasil diproses');
}


    public function reject(Request $request, string $id)
    {
        $transaksi = Transaksi::where('user_id', $id)
            ->where('type', 2)
            ->where('status', 1)
            ->first();

        if (!$transaksi) {
            Log::error("Reject withdraw gagal: transaksi tidak ditemukan", ['user_id' => $id]);
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $SG = new fiver();
        $act = json_decode($SG->deposit($transaksi->user_name, intval($transaksi->nominal)), true);

        Log::info("Reject withdraw Fiver", [
            'user_name' => $transaksi->user_name,
            'amount' => $transaksi->nominal,
            'api_response' => $act
        ]);

        if (isset($act['status']) && in_array($act['status'], [1, '1', 'success', 'SUCCESS'], true)) {
            $transaksi->status = 3;
            $transaksi->alasan = 'Reject by Admin';
            $transaksi->approved_at = now();
            $transaksi->approved_by = Auth::id();
            $transaksi->save();

            Log::info("Withdraw berhasil ditolak dan saldo dikembalikan", [
                'transaksi_id' => $transaksi->id,
                'status' => $transaksi->status
            ]);

            return redirect()->back()->with('success', 'Withdraw berhasil ditolak, saldo akan dikembalikan');
        } else {
            Log::error("Withdraw gagal di Fiver saat reject", [
                'user_name' => $transaksi->user_name,
                'amount' => $transaksi->nominal,
                'api_response' => $act
            ]);
            return redirect()->back()->with('error', 'Reject withdraw gagal, silakan coba lagi.');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function aksi(string $id, Request $request)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
