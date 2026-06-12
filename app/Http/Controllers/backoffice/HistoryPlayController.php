<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Api\fiver;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistoryPlayController extends Controller
{
    public function showForm(Request $request)
    {
        $userSearch = trim((string) $request->query('user_search', ''));

        $users = User::query()
            ->select('id', 'name', 'extplayer')
            ->when($userSearch !== '', function ($query) use ($userSearch) {
                $query->where(function ($inner) use ($userSearch) {
                    $inner->where('name', 'like', "%{$userSearch}%")
                        ->orWhere('extplayer', 'like', "%{$userSearch}%");
                });
            })
            ->whereNotNull('extplayer')
            ->orderBy('name')
            ->limit(100)
            ->get();

        return view('backoffice.history_play.history', compact('users', 'userSearch'));
    }

    public function getGameHistory(Request $request)
    {
        $request->validate([
            'extplayer' => 'required|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'game_type' => 'nullable|string|max:32',
        ]);

        try {
            $username = (string) $request->input('extplayer');
            $gameType = (string) ($request->input('game_type') ?: 'slot');
            $dateStart = $request->input('date_start')
                ? \Carbon\Carbon::parse($request->input('date_start'))->startOfDay()->format('Y-m-d H:i:s')
                : now()->subDays(7)->startOfDay()->format('Y-m-d H:i:s');
            $dateEnd = $request->input('date_end')
                ? \Carbon\Carbon::parse($request->input('date_end'))->endOfDay()->format('Y-m-d H:i:s')
                : now()->endOfDay()->format('Y-m-d H:i:s');

            $fiver = new fiver();
            $responseRaw = $fiver->historyPlay($username, $gameType, $dateStart, $dateEnd, 0, 200);

            if ($responseRaw === false || $responseRaw === null || $responseRaw === '') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'API tidak mengembalikan response. Cek koneksi endpoint atau status provider.',
                    'data' => [],
                    'columns' => [],
                    'meta' => $this->meta([], null),
                ], 502);
            }

            $response = json_decode($responseRaw, true);
            if (!is_array($response)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Response API bukan JSON valid.',
                    'data' => [],
                    'columns' => [],
                    'meta' => $this->meta([], null),
                ], 502);
            }

            $extracted = $this->extractRows($response, $gameType);
            $rows = $extracted['rows'];
            $sourceKey = $extracted['source_key'];
            $columns = $this->resolveColumns($rows);

            Log::info('FIVER HISTORY PLAY', [
                'username' => $username,
                'game_type' => $gameType,
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'source_key' => $sourceKey,
                'total_count' => $response['total_count'] ?? null,
                'row_count' => count($rows),
                'response_keys' => array_keys($response),
            ]);

            $data = collect($rows)->map(function ($row) use ($columns) {
                return collect($columns)->mapWithKeys(function ($column) use ($row) {
                    $value = $row[$column['key']] ?? '-';

                    if (is_array($value) || is_object($value)) {
                        $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }

                    return [$column['key'] => $value];
                })->all();
            })->values();

            return response()->json([
                'status' => 'success',
                'message' => $data->isEmpty() ? 'API berhasil dibaca, tetapi data riwayat kosong untuk filter ini.' : null,
                'data' => $data,
                'columns' => $columns,
                'meta' => $this->meta($response, $sourceKey, $data->count()),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error fetching FIVER history: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch game history. ' . $e->getMessage(),
                'data' => [],
                'columns' => [],
                'meta' => $this->meta([], null),
            ], 500);
        }
    }

    private function extractRows(array $response, string $gameType): array
    {
        $candidateKeys = array_values(array_unique([
            $gameType,
            'data',
            'slot',
            'slots',
            'casino',
            'live',
            'SB',
            'sb',
            'sport',
            'sports',
            'history',
            'histories',
            'logs',
            'rows',
            'result',
        ]));

        foreach ($candidateKeys as $key) {
            if (!array_key_exists($key, $response)) {
                continue;
            }

            $value = $response[$key];
            if (is_array($value) && isset($value['data']) && is_array($value['data'])) {
                $value = $value['data'];
            }

            if ($this->isListOfRows($value)) {
                return ['source_key' => $key, 'rows' => $value];
            }
        }

        if ($this->isListOfRows($response)) {
            return ['source_key' => 'root', 'rows' => $response];
        }

        return ['source_key' => null, 'rows' => []];
    }

    private function resolveColumns(array $rows): array
    {
        $priority = [
            'created_at',
            'updated_at',
            'date',
            'time',
            'provider_code',
            'provider',
            'game_code',
            'game_name',
            'user_code',
            'username',
            'bet_money',
            'bet',
            'win_money',
            'win',
            'balance',
            'txn_id',
            'transaction_id',
            'round_id',
            'txn_type',
            'type',
        ];

        $keys = [];
        foreach ($rows as $row) {
            if (is_array($row)) {
                $keys = array_values(array_unique(array_merge($keys, array_keys($row))));
            }
        }

        $ordered = array_values(array_intersect($priority, $keys));
        $remaining = array_values(array_diff($keys, $ordered));

        return collect(array_merge($ordered, $remaining))->map(fn ($key) => [
            'key' => $key,
            'label' => ucwords(str_replace('_', ' ', $key)),
        ])->values()->all();
    }

    private function isListOfRows($value): bool
    {
        if (!is_array($value) || $value === []) {
            return false;
        }

        return array_keys($value) === range(0, count($value) - 1)
            && collect($value)->every(fn ($row) => is_array($row));
    }

    private function meta(array $response, ?string $sourceKey, int $rowCount = 0): array
    {
        return [
            'source_key' => $sourceKey,
            'total_count' => (int) ($response['total_count'] ?? $rowCount),
            'page' => (int) ($response['page'] ?? 1),
            'perPage' => (int) ($response['perPage'] ?? 200),
            'api_status' => $response['status'] ?? null,
            'raw_keys' => array_keys($response),
        ];
    }
}
