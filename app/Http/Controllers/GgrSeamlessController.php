<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Saldo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GgrSeamlessController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $method = (string) $request->input('method');

        return match ($method) {
            'user_balance' => $this->userBalance($request),
            'transaction' => $this->transaction($request),
            default => response()->json([
                'status' => 0,
                'msg' => 'INVALID_METHOD',
            ], 400),
        };
    }

    private function userBalance(Request $request): JsonResponse
    {
        if (!$this->validAgent($request)) {
            return $this->failure('INVALID_AGENT');
        }

        $user = $this->findUser((string) $request->input('user_code'));
        if (!$user) {
            return $this->failure('INVALID_USER');
        }

        return response()->json([
            'status' => 1,
            'user_balance' => $this->balanceFor($user),
        ]);
    }

    private function transaction(Request $request): JsonResponse
    {
        if (!$this->validAgent($request)) {
            return $this->failure('INVALID_AGENT');
        }

        $user = $this->findUser((string) $request->input('user_code'));
        if (!$user) {
            return $this->failure('INVALID_USER');
        }

        $gameType = (string) $request->input('game_type', 'slot');
        $gamePayload = (array) $request->input($gameType, []);
        if ($gamePayload === [] && $gameType === 'SB') {
            $gamePayload = (array) $request->input('SB', []);
        }

        $txnId = (string) ($gamePayload['txn_id'] ?? '');
        if ($txnId === '') {
            return $this->failure('INVALID_TRANSACTION');
        }

        $existing = DB::table('ggr_seamless_transactions')->where('txn_id', $txnId)->first();
        if ($existing) {
            return response()->json([
                'status' => 1,
                'user_balance' => (float) $existing->balance_after,
            ]);
        }

        $txnType = (string) ($gamePayload['txn_type'] ?? 'debit_credit');
        $bet = (float) ($gamePayload['bet_money'] ?? 0);
        $win = (float) ($gamePayload['win_money'] ?? 0);

        return DB::transaction(function () use ($request, $user, $gameType, $gamePayload, $txnId, $txnType, $bet, $win) {
            $saldo = Saldo::query()->lockForUpdate()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'user_name' => $user->name,
                    'saldo' => 0,
                    'bonus' => 0,
                    'status' => 1,
                ]
            );

            $before = (float) ($saldo->saldo ?? 0);
            $after = match ($txnType) {
                'debit' => $before - $bet,
                'credit' => $before + $win,
                default => $before - $bet + $win,
            };

            if ($after < 0) {
                return $this->failure('INSUFFICIENT_USER_FUNDS');
            }

            $saldo->saldo = $after;
            $saldo->user_name = $user->name;
            $saldo->save();

            DB::table('ggr_seamless_transactions')->insert([
                'txn_id' => $txnId,
                'user_id' => $user->id,
                'user_code' => $user->name,
                'game_type' => $gameType,
                'provider_code' => $gamePayload['provider_code'] ?? null,
                'game_code' => $gamePayload['game_code'] ?? null,
                'txn_type' => $txnType,
                'bet_money' => $bet,
                'win_money' => $win,
                'balance_before' => $before,
                'balance_after' => $after,
                'payload' => json_encode($request->all(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 1,
                'user_balance' => $after,
            ]);
        });
    }

    private function validAgent(Request $request): bool
    {
        $api = Api::query()->first();
        $secret = (string) ($api->nx_secret ?? '');

        if ($secret === '') {
            Log::warning('GGR seamless request rejected: nx_secret is empty');
            return false;
        }

        return hash_equals((string) ($api->nx_agent_code ?? ''), (string) $request->input('agent_code'))
            && hash_equals($secret, (string) $request->input('agent_secret'));
    }

    private function findUser(string $userCode): ?User
    {
        return User::query()
            ->where('name', $userCode)
            ->orWhere('extplayer', $userCode)
            ->first();
    }

    private function balanceFor(User $user): float
    {
        return (float) (Saldo::query()->where('user_id', $user->id)->value('saldo') ?? 0);
    }

    private function failure(string $message): JsonResponse
    {
        return response()->json([
            'status' => 0,
            'user_balance' => 0,
            'msg' => $message,
        ]);
    }
}
