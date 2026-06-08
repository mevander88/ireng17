<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use App\Models\Game;
use App\Http\Api\softgaming;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function connect_games($game)
    {
        $fiver = new fiver();

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Masuk ke akun Anda untuk membuka permainan.');
        }

        $catalogGame = $this->resolveGame($game);

        if (!$catalogGame) {
            return back()->with('error', 'Permainan tidak tersedia. Silakan pilih permainan lain.');
        }

        // Jalankan API untuk membuka game, bahasa diatur 'id'
        $response = $fiver->opengame(
            $user->name,
            $catalogGame->game_code,
            $catalogGame->game_provider,
            'id' // parameter lang ditambahkan
        );

        $data = json_decode($response, true);

        // Jika sukses, redirect ke URL game
        if (isset($data['status']) && ($data['status'] == 1 || $data['status'] == 'success') && !empty($data['launch_url'])) {
            return redirect()->away($data['launch_url']);
        }

        // Jika gagal, log error dan balik dengan pesan
        Log::error('Fiver API error', [
            'user' => $user->name,
            'game' => $game,
            'response' => $response
        ]);

        return back()->with('error', $this->friendlyLaunchMessage($data['msg'] ?? null));
    }

    private function resolveGame(string $game): ?object
    {
        if (str_starts_with($game, 'api:')) {
            $parts = explode(':', $game, 3);

            if (count($parts) === 3) {
                return (object) [
                    'game_provider' => rawurldecode($parts[1]),
                    'game_code' => rawurldecode($parts[2]),
                ];
            }
        }

        $localGame = DB::table('fiver_games')->where('id', $game)->first()
            ?? DB::table('games')->where('id', $game)->first();

        if (!$localGame || empty($localGame->game_code) || empty($localGame->game_provider)) {
            return null;
        }

        return $localGame;
    }

    private function friendlyLaunchMessage(?string $message): string
    {
        $message = strtolower((string) $message);

        if (str_contains($message, 'invalid_provider')) {
            return 'Provider sedang tidak tersedia. Silakan pilih permainan lain.';
        }

        if (str_contains($message, 'invalid') || str_contains($message, 'parameter')) {
            return 'Permainan belum bisa dibuka. Silakan coba permainan lain.';
        }

        if (str_contains($message, 'balance')) {
            return 'Saldo belum cukup untuk membuka permainan ini.';
        }

        return 'Permainan belum bisa dibuka saat ini. Silakan coba lagi beberapa saat.';
    }
}
