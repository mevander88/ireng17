<?php

namespace App\Http\Controllers;

use App\Models\Spin;
use App\Http\Api\fiver;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpinController extends Controller
{
    public function index()
    {
        return redirect('/promotion');
    }
    public function spinPrize(Request $request)
    {
        $allowedPrizes = config('services.lucky_spin_prizes', []);
        if ($allowedPrizes === []) {
            return response()->json(['error' => 'Lucky spin belum dikonfigurasi.'], 503);
        }

        $validated = $request->validate([
            'voucher' => ['required', 'string', 'max:32'],
            'prize' => ['required', 'integer', 'in:' . implode(',', $allowedPrizes)],
        ]);

        $user = $request->user();
        $prize = (int) $validated['prize'];

        try {
            $result = DB::transaction(function () use ($validated, $user, $prize) {
                $voucher = Voucher::where('code', $validated['voucher'])
                    ->where('is_valid', true)
                    ->lockForUpdate()
                    ->first();

                if (!$voucher) {
                    return ['error' => 'Voucher tidak valid atau sudah digunakan.'];
                }

                $voucher->is_valid = false;
                $voucher->save();

                $SG = new fiver();
                $act = json_decode($SG->deposit($user->name, $prize));

                Spin::create([
                    'user_id' => $user->id,
                    'prize' => $prize,
                ]);

                return ['prize' => $prize, 'data' => $act];
            });

            if (isset($result['error'])) {
                return response()->json($result, 422);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            Log::warning('Failed to save spin data', ['user_id' => $request->user()?->id, 'error' => $e->getMessage()]);
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
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false]);
        }
    }
}
