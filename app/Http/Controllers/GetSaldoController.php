<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GetSaldoController extends Controller
{
    /**
     * Ambil saldo realtime semua user dari API Fiver
     * Otomatis buat extplayer jika kosong
     */
    public function saldo()
    {
        $users = User::all();
        $api = new fiver();
        $results = [];

        foreach ($users as $user) {
            // Jika extplayer kosong, buatkan otomatis
            if (empty($user->extplayer)) {
                $user->extplayer = $user->name . mt_rand(100, 999);
                $user->save();
            }

            $extplayer = $user->extplayer;

            // Ambil saldo dari API
            $response = $api->userbalance($extplayer);
            $act = json_decode($response, true);

            if (!$act) {
                Log::error("Gagal decode response API untuk user {$user->name}");
                $results[] = "❌ {$user->name} gagal sync: response tidak valid";
                continue;
            }

            // Jika API sukses dan ada user
            if (isset($act['status']) && $act['status'] == 1 && !empty($act['user']['user_code'])) {
                $userSaldo = Saldo::where('user_name', $act['user']['user_code'])->first();

                if ($userSaldo) {
                    $userSaldo->saldo = $act['user']['balance'] ?? 0;
                    $userSaldo->save();
                    $results[] = "✅ {$user->name} berhasil sync saldo: {$userSaldo->saldo}";
                } else {
                    // Jika belum ada record saldo, buat baru
                    Saldo::create([
                        'user_id'   => $user->id,
                        'user_name' => $act['user']['user_code'],
                        'saldo'     => $act['user']['balance'] ?? 0,
                        'bonus'     => 0,
                    ]);
                    $results[] = "✅ {$user->name} berhasil membuat record saldo baru: {$act['user']['balance']}";
                }
            } else {
                // Jika API tidak mengembalikan user
                $results[] = "❌ {$user->name} gagal sync: tidak ada field saldo dalam API";
                Log::warning("Gagal update saldo user {$user->name}", ['response' => $act]);
            }
        }

        return response()->json([
            'status' => 'success',
            'synced' => count($results),
            'results' => $results
        ]);
    }
}
