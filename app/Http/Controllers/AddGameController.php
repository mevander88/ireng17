<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AddGameController extends Controller
{
    public function index()
    {
        $SG = new fiver();
        $providerResponse = json_decode($SG->providerlist());
        $providers = collect($providerResponse->providers ?? [])
            ->filter(fn ($provider) => (int) ($provider->status ?? 0) === 1)
            ->pluck('code')
            ->values();

        $summary = [];

        foreach ($providers as $provider) {
            $act = json_decode($SG->gamelist($provider));
            $gameList = $act->games ?? $act->gamelist ?? [];

            if (!is_array($gameList)) {
                $summary[$provider] = [
                    'synced' => 0,
                    'status' => $act->status ?? null,
                    'code' => $act->code ?? null,
                    'message' => $act->message ?? $act->msg ?? 'API response tidak berisi games',
                ];
                continue;
            }

            $synced = 0;

            foreach ($gameList as $games) {
                if (empty($games->game_code) || empty($games->game_name)) {
                    continue;
                }

                DB::table('fiver_games')->updateOrInsert(
                    [
                        'game_code' => $games->game_code,
                        'game_provider' => $games->game_provider ?? $provider,
                    ],
                    [
                        'game_name' => $games->game_name,
                        'game_category' => $games->game_type ?? $games->game_category ?? 'slot',
                        'game_image' => $games->banner ?? $games->game_image ?? '',
                        'status' => (string) ($games->status ?? 1),
                        'updated_at' => now(),
                    ]
                );

                $synced++;
            }

            $summary[$provider] = ['synced' => $synced];
            sleep(1);
        }

        Log::info('Game API sync completed', $summary);

        return response()->json([
            'ok' => true,
            'summary' => $summary,
        ]);
    }

    public function deleteGames()
    {
        // Menggunakan Eloquent
        // FiverGame::whereBetween('id', [2015, 2220])->delete();

        // Atau, menggunakan Query Builder
        DB::table('fiver_games')->whereBetween('id', [3578, 4277])->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
