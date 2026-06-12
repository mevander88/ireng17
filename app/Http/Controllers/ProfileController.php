<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Saldo;
use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $user = Auth::user();
        $saldo = (float) (Saldo::where('user_id', $user->id)->value('saldo') ?? 0);
        $depositDelay = (int) ($setting->deposit_delay ?? 24);
        $pendingDeposit = Transaksi::activePendingDepositForUser($user->id, $depositDelay)
            ->latest()
            ->first();
        $successfulDeposits = Transaksi::where('user_id', $user->id)
            ->where('type', 1)
            ->where('status', 2)
            ->count();
        $successfulWithdraws = Transaksi::where('user_id', $user->id)
            ->where('type', 2)
            ->where('status', 2)
            ->count();
        $accountComplete = filled($user->nama_rek)
            && filled($user->bank)
            && filled($user->no_rek)
            && filled($user->telp);

        return view('profile', compact(
            'setting',
            'saldo',
            'pendingDeposit',
            'successfulDeposits',
            'successfulWithdraws',
            'accountComplete'
        ));
    }
}
