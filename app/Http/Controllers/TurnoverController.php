<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TurnoverController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('user_id', Auth()->user()->id)->where('status', 2)->with('Bonus')->where('type', 1)->first();
        return view('promo-saya', compact('transaksi'));
    }

    public function getBonusPromotion()
    {
        $transaksis = Transaksi::where('user_id', Auth()->user()->id)->where('status', 2)->with('Bonus')->where('type', 1)->get();
        return response()->json(['transaksis' => $transaksis]);
    }

    public function turnOver()
    {
        $game_type = 'slot';
        $page = 0;
        $perPage = 1000;
        $targetValue = 1000000; // 1 juta

        $endDate = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $startDate = Carbon::now('Asia/Jakarta')->subHours(24)->format('Y-m-d H:i:s');

        $SG = new fiver();
        $response = $SG->historyPlay(Auth::user()->name, $game_type, $startDate, $endDate, $page, $perPage, true);

        $act = json_decode($response, true);

        if (isset($act['slot']) && is_array($act['slot'])) {
            $bet_money_values = array_map(function ($spin) {
                return $spin['bet_money'];
            }, $act['slot']);

            $spin = $act['total_count'];
            $turnover = array_sum($bet_money_values);

            // Get the latest entry
            $latest_entry = end($act['slot']);
            $latest_bet = $latest_entry['bet_money'];
            $latest_date = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');

            $progressive = ($turnover / $targetValue) * 100;
            if ($progressive > 100) {
                $progressive = 100;
            }
        } else {
            $spin = 0;
            $turnover = 0;
            $progressive = 0;
            $latest_bet = 0;
            $latest_date = null;
        }

        // Return response as JSON
        return response()->json([
            'spin' => $spin,
            'turnover' => $turnover,
            'progressive' => $progressive,
            'latest_bet' => $latest_bet,
            'latest_date' => $latest_date,
        ]);
    }
}
