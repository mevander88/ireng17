<?php

namespace App\Services;

use App\Http\Api\fiver;
use App\Models\GgrGame;
use App\Models\GgrProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GgrCatalogService
{
    private const EXCLUDED_PROVIDER_CODES = [
        'AMUSNET',
        'FACHAI',
        'FASTSPIN',
        'HACKSAW',
        'SPADEGAMING',
    ];

    public function providers(?string $type = null): Collection
    {
        $query = GgrProvider::query()
            ->where('is_open', true)
            ->whereNotIn('code', self::EXCLUDED_PROVIDER_CODES)
            ->with('coverGame')
            ->withCount(['games' => fn ($query) => $query->where('is_open', true)])
            ->orderByRaw("
                CASE code
                    WHEN 'PRAGMATIC' THEN 1
                    WHEN 'PGSOFT' THEN 2
                    WHEN 'HABANERO' THEN 3
                    WHEN 'CQ9' THEN 4
                    WHEN 'JOKERGAMING' THEN 5
                    WHEN 'PLAYNGO' THEN 6
                    WHEN 'SPADEGAMING' THEN 7
                    WHEN 'EVOLUTION' THEN 8
                    WHEN 'PP_LIVE_PRO' THEN 9
                    WHEN 'SPORTSBOOK' THEN 10
                    ELSE 99
                END
            ")
            ->orderByRaw("FIELD(type, 'slot', 'live', 'MN', 'SB') ASC")
            ->orderBy('name');

        if ($type) {
            $query->where('type', $type);
        }

        return $query->get();
    }

    public function featuredGames(int $limit = 24): Collection
    {
        return GgrGame::query()
            ->where('is_open', true)
            ->whereNotIn('provider_code', self::EXCLUDED_PROVIDER_CODES)
            ->where('type', 'slot')
            ->whereNotNull('banner')
            ->where('banner', '<>', '')
            ->where('banner', 'not like', '%://spribe.co/%')
            ->where('banner', 'not like', '%://www.spribe.co/%')
            ->where('banner', 'not like', '%://spadegaming.com/%')
            ->where('banner', 'not like', '%://www.spadegaming.com/%')
            ->orderByDesc('updated_at')
            ->limit($limit)
            ->get();
    }

    public function popularSlotGames(int $limit = 24): Collection
    {
        $popularNames = [
            'Mahjong Ways 2',
            'Mahjong Ways',
            'Wild Bounty Showdown',
            'Gates of Olympus 1000',
            'Gates of Olympus',
            'Sweet Bonanza 1000',
            'Sweet Bonanza',
            'Starlight Princess 1000',
            'Starlight Princess',
            'Wild Bandito',
            'Lucky Neko',
            'Koi Gate',
            'Mahjong Wins 2',
            'Mahjong Wins',
            'Mahjong Wins 3',
            'Sugar Rush 1000',
        ];

        $prioritySql = collect($popularNames)
            ->map(fn ($name, $index) => "WHEN game_name LIKE ? THEN " . ($index + 1))
            ->implode(' ');
        $bindings = collect($popularNames)->map(fn ($name) => '%' . $name . '%')->all();

        return GgrGame::query()
            ->where('is_open', true)
            ->whereNotIn('provider_code', self::EXCLUDED_PROVIDER_CODES)
            ->where('type', 'slot')
            ->whereNotNull('banner')
            ->where('banner', '<>', '')
            ->where('banner', 'not like', '%://spribe.co/%')
            ->where('banner', 'not like', '%://www.spribe.co/%')
            ->where('banner', 'not like', '%://spadegaming.com/%')
            ->where('banner', 'not like', '%://www.spadegaming.com/%')
            ->where(function ($query) use ($popularNames) {
                foreach ($popularNames as $name) {
                    $query->orWhere('game_name', 'like', '%' . $name . '%');
                }
            })
            ->orderByRaw("CASE {$prioritySql} ELSE 999 END", $bindings)
            ->orderByRaw("CASE provider_code WHEN 'PGSOFT' THEN 1 WHEN 'PRAGMATIC' THEN 2 WHEN 'HABANERO' THEN 3 ELSE 9 END")
            ->orderBy('game_name')
            ->limit($limit)
            ->get();
    }

    public function gamesForProvider(string $providerCode, ?string $search = null, int $limit = 120): Collection
    {
        return GgrGame::query()
            ->where('provider_code', $providerCode)
            ->whereNotIn('provider_code', self::EXCLUDED_PROVIDER_CODES)
            ->where('is_open', true)
            ->when($search, fn ($query) => $query->where('game_name', 'like', '%' . $search . '%'))
            ->orderByRaw("
                CASE
                    WHEN game_name LIKE '%Mahjong Ways 2%' THEN 1
                    WHEN game_name LIKE '%Mahjong Ways%' THEN 2
                    WHEN game_name LIKE '%Wild Bounty Showdown%' THEN 3
                    WHEN game_name LIKE '%Gates of Olympus 1000%' THEN 4
                    WHEN game_name LIKE '%Gates of Olympus%' THEN 5
                    WHEN game_name LIKE '%Sweet Bonanza 1000%' THEN 6
                    WHEN game_name LIKE '%Sweet Bonanza%' THEN 7
                    WHEN game_name LIKE '%Starlight Princess 1000%' THEN 8
                    WHEN game_name LIKE '%Starlight Princess%' THEN 9
                    WHEN game_name LIKE '%Wild Bandito%' THEN 10
                    WHEN game_name LIKE '%Lucky Neko%' THEN 11
                    ELSE 99
                END
            ")
            ->orderBy('game_name')
            ->limit($limit)
            ->get();
    }

    public function providerBySlug(string $slug): ?GgrProvider
    {
        return GgrProvider::query()
            ->where('is_open', true)
            ->whereNotIn('code', self::EXCLUDED_PROVIDER_CODES)
            ->get()
            ->first(fn (GgrProvider $provider) => Str::slug($provider->code) === Str::slug($slug));
    }

    public function syncProviders(): array
    {
        $response = $this->callProviderList();

        if ((int) ($response['status'] ?? 0) !== 1 || empty($response['providers'])) {
            return [
                'ok' => false,
                'message' => $response['msg'] ?? 'Provider API belum mengembalikan data.',
                'synced' => 0,
            ];
        }

        $synced = 0;

        foreach ($response['providers'] as $provider) {
            if (empty($provider['code']) || empty($provider['name'])) {
                continue;
            }

            $code = strtoupper((string) $provider['code']);

            GgrProvider::updateOrCreate(
                ['code' => $provider['code']],
                [
                    'name' => $provider['name'],
                    'type' => (string) ($provider['type'] ?? 'slot'),
                    'is_open' => !in_array($code, self::EXCLUDED_PROVIDER_CODES, true)
                        && (int) ($provider['status'] ?? 0) === 1,
                    'synced_at' => now(),
                ]
            );

            $synced++;
        }

        Cache::forget('ggr.provider_list.raw');

        return ['ok' => true, 'message' => 'Provider berhasil disinkronkan.', 'synced' => $synced];
    }

    public function syncGames(?string $providerCode = null, int $maxProviders = 12): array
    {
        if (GgrProvider::count() === 0) {
            $this->syncProviders();
        }

        $providers = GgrProvider::query()
            ->where('is_open', true)
            ->whereNotIn('code', self::EXCLUDED_PROVIDER_CODES)
            ->when($providerCode, fn ($query) => $query->where('code', $providerCode))
            ->orderByRaw('synced_at is null desc')
            ->orderBy('synced_at')
            ->limit($providerCode ? 1 : $maxProviders)
            ->get();

        $summary = [];

        foreach ($providers as $index => $provider) {
            if ($index > 0) {
                sleep(1);
            }

            $summary[$provider->code] = $this->syncProviderGames($provider);
        }

        return $summary;
    }

    public function syncProviderGames(GgrProvider $provider): array
    {
        $response = $this->callGameList($provider->code);

        if ((int) ($response['status'] ?? 0) !== 1 || !isset($response['games']) || !is_array($response['games'])) {
            return [
                'ok' => false,
                'message' => $response['msg'] ?? 'Game API belum mengembalikan data.',
                'synced' => 0,
            ];
        }

        $synced = 0;

        foreach ($response['games'] as $game) {
            if (empty($game['game_name'])) {
                continue;
            }

            GgrGame::updateOrCreate(
                [
                    'provider_code' => $provider->code,
                    'game_code' => (string) ($game['game_code'] ?? ''),
                ],
                [
                    'ggr_provider_id' => $provider->id,
                    'game_name' => $game['game_name'],
                    'type' => $provider->type,
                    'banner' => $game['banner'] ?? null,
                    'is_open' => (int) ($game['status'] ?? 0) === 1,
                    'synced_at' => now(),
                ]
            );

            $synced++;
        }

        $provider->forceFill(['synced_at' => now()])->save();

        return ['ok' => true, 'message' => 'Game berhasil disinkronkan.', 'synced' => $synced];
    }

    private function callProviderList(): array
    {
        return Cache::remember('ggr.provider_list.raw', now()->addMinutes(2), function () {
            try {
                return json_decode((new fiver())->providerlist(), true) ?: [];
            } catch (\Throwable $exception) {
                Log::warning('GGR provider_list failed', ['error' => $exception->getMessage()]);
                return [];
            }
        });
    }

    private function callGameList(string $providerCode): array
    {
        try {
            return json_decode((new fiver())->gamelist($providerCode), true) ?: [];
        } catch (\Throwable $exception) {
            Log::warning('GGR game_list failed', ['provider' => $providerCode, 'error' => $exception->getMessage()]);
            return [];
        }
    }
}
