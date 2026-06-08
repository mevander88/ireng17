<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use Illuminate\Http\Request;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Api\softgaming;
use App\Models\Network;

class UserWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SG = new fiver();
        $act = json_decode($SG->userbalance(Auth()->user()->name));
        $saldos = $act->user->balance ?? '0';

        $rek = Auth::user();

        return view('account.withdraw', compact('saldos', 'rek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek withdraw pending
        $pending = Transaksi::where('user_id', Auth::user()->id)
            ->where('type', 2)
            ->where('status', 1)
            ->first();
        if ($pending) {
            return back()->with('info', 'Tunggu Withdraw Sebelumnya Diterima !');
        }

        // Validasi input
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'acc_no' => 'required|string'
        ]);

        $amount = intval($request->amount);

        $SG = new fiver();
        $act = json_decode($SG->withdraw(Auth()->user()->name, $amount), true);

        // Revisi pengecekan status Fiver
        if (isset($act['status']) && in_array($act['status'], [1, '1', 'success', 'SUCCESS'], true)) {

            $transaksi = new Transaksi();
            $transaksi->type = 2;
            $transaksi->status = 1;
            $transaksi->trans_id = getTrx();
            $transaksi->user_name = Auth::user()->name;
            $transaksi->nominal = $amount;
            $transaksi->rek_pengirim = $request->acc_no ?? Auth::user()->no_rek;
            $transaksi->keterangan = Auth::user()->bank . ' - ' . Auth::user()->no_rek;
            $transaksi->user_id = Auth::user()->id;
            $transaksi->ref = Auth::user()->ref_code ?? null;

            Log::info("Attempt save withdraw", [
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
                'amount' => $amount,
                'rek_pengirim' => $transaksi->rek_pengirim,
            ]);

            $transaksi->save();

            Log::info("Withdraw saved successfully", [
                'transaksi_id' => $transaksi->id,
                'status' => $transaksi->status,
                'type' => $transaksi->type,
            ]);

            return redirect()->back()->with('success', 'Withdraw berhasil diajukan.');
        } else {
            Log::error("Withdraw gagal di Fiver", [
                'user' => Auth()->user()->name,
                'amount' => $amount,
                'api_response' => $act
            ]);
            return back()->with('error', 'Withdraw gagal, silakan coba lagi.');
        }
    }

    /**
     * Update / aksi withdraw (approve/reject)
     */
    public function aksi(string $id, Request $request)
    {
        $transaksi = Transaksi::find($id);
        $User = User::findOrFail($transaksi->user_id);

        if ($request->status == 3 && $transaksi->type == 2) {
            $SG = new fiver();
            $act = json_decode($SG->deposit($User->name, $transaksi->nominal));

            if (isset($act->status) && in_array($act->status, [1, '1', 'success', 'SUCCESS'], true)) {
                $actBalance = json_decode($SG->userbalance($User->name));
                $saldo = Saldo::where('user_id', $transaksi->user_id)->first();
                $saldo->saldo = $actBalance->user->balance;
                $saldo->save();

                $transaksi->user_name = $User->name;
                $transaksi->status = $request->status;
                $transaksi->alasan = $request->alasan;
                $transaksi->approved_at = date('Y-m-d H:i:s');
                $transaksi->approved_by = auth()->user()->id;
                $transaksi->save();

                Log::info("Withdraw rejected and refunded", [
                    'transaksi_id' => $transaksi->id,
                    'user_name' => $User->name,
                    'amount' => $transaksi->nominal,
                ]);
            }
        } else {
            $transaksi->status = $request->status;
            $transaksi->alasan = $request->alasan;
            $transaksi->approved_at = date('Y-m-d H:i:s');
            $transaksi->approved_by = auth()->user()->id;
            $transaksi->save();

            Log::info("Withdraw status updated", [
                'transaksi_id' => $transaksi->id,
                'status' => $transaksi->status,
            ]);
        }

        return redirect()->back()->with('success', 'Data changed successfully');
    }

    public function WD()
    {
        $SG = new fiver();
        $act =  json_decode($SG->resetBalance());
        return $act;
    }
}
