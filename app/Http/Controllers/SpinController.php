<?php

namespace App\Http\Controllers;

use App\Models\Spin;
use App\Http\Api\fiver;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpinController extends Controller
{

    public function index()
    {
        return redirect('/promotion');
    }
    public function spinPrize(Request $request)
    {
        try {
            $prize = $request->input('prize');
            $prizeNumber = intval($prize);
            $SG = new fiver();
            $act = json_decode($SG->deposit(Auth()->user()->name, $prizeNumber));

            $spin = new Spin();
            $spin->user_id = auth()->user()->id;
            $spin->prize = $prize;
            $spin->save();

            return response()->json(['prize' => $prize, 'data' => $act]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to save spin data'], 500);
        }
    }

    public function validateVoucher(Request $request)
    {
        $request->validate([
            'voucher' => 'required|string',
        ]);

        $voucher = Voucher::where('code', $request->voucher)->first();

        if ($voucher && $voucher->is_valid) {
            // Tandai voucher sebagai sudah digunakan
            $voucher->is_valid = false;
            $voucher->save();

            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }
}
