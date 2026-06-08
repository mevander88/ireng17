<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Api\softgaming;
use App\Models\Transaksi;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BackofficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dashboard datas
        $trans = new Transaksi();
        $data['deposit'] = $trans->get_summary_transaksi();

        $member = new User();
        $data['member'] = $member->get_summary_member();


        return view('backoffice.backoffice', $data);
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

    public function agentbalance()
{
    $SG = new \App\Http\Api\fiver();
    $act = json_decode($SG->agentbalance());

    // Pastikan response terdefinisi
    if (isset($act->status) && $act->status === 'success') {
        // Cek apakah object data dan balance ada
        $balance = $act->data->balance ?? 0;
    } else {
        // Jika gagal ambil dari API
        $balance = 0;
    }

    return response()->json([
        'status' => $act->status ?? 'error',
        'balance' => $balance,
    ]);
}

    public function getTotalBersihHarian()
    {
        // Mendapatkan tanggal hari ini
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        // Menghitung total deposit hari ini
        $totalDeposit = Transaksi::where('type', 1)
            ->where('status', 2)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('nominal');


        $totalWithdraw = Transaksi::where('type', 2)
            ->where('status', 2)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('nominal');

        $totalBersih = $totalDeposit - $totalWithdraw;

        return response()->json([
            'total_bersih' => $totalBersih,
        ]);
    }
}
