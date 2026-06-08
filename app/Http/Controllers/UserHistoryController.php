<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Http\Api\softgaming;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SG = new fiver();
        $act = json_decode($SG->userbalance(Auth()->user()->name));
        $saldos = $act->user->balance ?? 'x';

        // Mengambil transaksi terakhir untuk user yang sudah dibayar (status = 2)
        $transaksi = Transaksi::with('Bank')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Mengambil transaksi yang statusnya sudah dibayar (status = 2)
        $jumlah = Transaksi::where('user_id', Auth::user()->id)
            ->where('status', 2) // Hanya transaksi yang berhasil
            ->get();

        // Menghitung total nominal transaksi yang berhasil
        $totalNominal = $jumlah->sum('nominal');

        return view('account.lastDirectTransfer', compact('saldos', 'transaksi', 'totalNominal'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
