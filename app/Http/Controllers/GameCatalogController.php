<?php

namespace App\Http\Controllers;

use App\Http\Api\fiver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GameCatalogController extends Controller
{
    private const LEGACY_SLUG_MAP = [
        'pgsoft' => 'PGSOFT',
        'habanero' => 'HABANERO',
        'toptrend' => 'TOPTREND',
        'dreamtech' => 'DREAMTECH',
        'booongo' => 'BOOONGO',
        'playson' => 'PLAYSON',
        'cq9' => 'CQ9',
        'reelkingdom' => 'REELKINGDOM',
        'evoplay' => 'EVOPLAY',
        'pragmatic' => 'PRAGMATIC',
        'playngo' => 'PLAYNGO',
        'spadegaming' => 'SPADEGAMING',
        'joker' => 'JOKERGAMING',
        'joker-gaming' => 'JOKERGAMING',
        'jokergaming' => 'JOKERGAMING',
        'spribe' => 'SPRIBE',
        'sportsbook' => 'SPORTSBOOK',
        'evolution' => 'EVOLUTION',
        'pp-live-pro' => 'PP_LIVE_PRO',
        'hackshaw' => 'HACKSAW',
        'hacksaw' => 'HACKSAW',
        'fatpanda' => 'FATPANDA',
        'fachai' => 'FACHAI',
        'amusnet' => 'AMUSNET',
        'egt' => 'EGT',
        'fastspin' => 'FASTSPIN',
        'qqkeno' => 'QK',
        'microgaming' => 'MP',
        'playstar' => 'PS',
        'evo' => 'EP',
        'nolimitcity' => 'GE',
        'advantplay' => 'AD',
        'playtech' => 'FR',
        'ygg' => 'YD',
    ];

    private const FALLBACK_BY_PROVIDER = [
        'PGSOFT' => ['table' => 'fiver_games', 'provider' => 'PGSOFT', 'category' => 'slot'],
        'HABANERO' => ['table' => 'fiver_games', 'provider' => 'HABANERO', 'category' => null],
        'TOPTREND' => ['table' => 'fiver_games', 'provider' => 'TOPTREND', 'category' => 'slot'],
        'DREAMTECH' => ['table' => 'fiver_games', 'provider' => 'DREAMTECH', 'category' => 'slot'],
        'BOOONGO' => ['table' => 'fiver_games', 'provider' => 'BOOONGO', 'category' => 'slot'],
        'PLAYSON' => ['table' => 'fiver_games', 'provider' => 'PLAYSON', 'category' => 'slot'],
        'CQ9' => ['table' => 'fiver_games', 'provider' => 'CQ9', 'category' => 'slot'],
        'REELKINGDOM' => ['table' => 'fiver_games', 'provider' => 'REELKINGDOM', 'category' => 'slot'],
        'EVOPLAY' => ['table' => 'fiver_games', 'provider' => 'EVOPLAY', 'category' => 'slot'],
        'PRAGMATIC' => ['table' => 'fiver_games', 'provider' => 'PRAGMATIC', 'category' => 'slot'],
        'PLAYNGO' => ['table' => 'games', 'provider' => 'PN', 'category' => 'SL'],
        'SPADEGAMING' => ['table' => 'games', 'provider' => 'SG', 'category' => 'SL'],
        'JOKERGAMING' => ['table' => 'games', 'provider' => 'JK', 'category' => 'SL'],
        'QK' => ['table' => 'games', 'provider' => 'QK', 'category' => 'LK'],
        'MP' => ['table' => 'games', 'provider' => 'MP', 'category' => 'SL'],
        'PS' => ['table' => 'games', 'provider' => 'PS', 'category' => 'SL'],
        'EP' => ['table' => 'games', 'provider' => 'EP', 'category' => 'SL'],
        'GE' => ['table' => 'games', 'provider' => 'GE', 'category' => 'SL'],
        'AD' => ['table' => 'games', 'provider' => 'AD', 'category' => 'SL'],
        'FR' => ['table' => 'games', 'provider' => 'FR', 'category' => 'SL'],
        'YD' => ['table' => 'games', 'provider' => 'YD', 'category' => 'SL'],
    ];

    private const CATEGORY_PROVIDERS = [
        'sports' => [
            ['api' => 'SPORTSBOOK', 'fallback' => ['table' => 'games', 'provider' => 'IB', 'category' => 'SB']],
        ],
        'casino' => [
            ['api' => 'EVOLUTION', 'fallback' => ['table' => 'games', 'provider' => 'E0', 'category' => 'LC']],
            ['api' => 'PP_LIVE_PRO', 'fallback' => ['table' => 'games', 'provider' => 'PR', 'category' => 'LC']],
        ],
        'p2p' => [
            ['api' => 'FG', 'fallback' => ['table' => 'games', 'provider' => 'FG', 'category' => 'PK']],
        ],
        'fish-hunter' => [
            ['api' => 'CQ', 'fallback' => ['table' => 'games', 'provider' => 'CQ', 'category' => 'FH']],
            ['api' => 'FG', 'fallback' => ['table' => 'games', 'provider' => 'FG', 'category' => 'FH']],
            ['api' => 'GB', 'fallback' => ['table' => 'games', 'provider' => 'GB', 'category' => 'FH']],
            ['api' => 'JA', 'fallback' => ['table' => 'games', 'provider' => 'JA', 'category' => 'FH']],
            ['api' => 'JD', 'fallback' => ['table' => 'games', 'provider' => 'JD', 'category' => 'FH']],
            ['api' => 'JK', 'fallback' => ['table' => 'games', 'provider' => 'JK', 'category' => 'FH']],
            ['api' => 'SG', 'fallback' => ['table' => 'games', 'provider' => 'SG', 'category' => 'FH']],
        ],
        'lottery' => [
            ['api' => 'JD', 'fallback' => ['table' => 'games', 'provider' => 'JD', 'category' => 'LK']],
            ['api' => 'ND', 'fallback' => ['table' => 'games', 'provider' => 'ND', 'category' => 'LK']],
            ['api' => 'QK', 'fallback' => ['table' => 'games', 'provider' => 'QK', 'category' => 'LK']],
        ],
        'e-games' => [
            ['api' => 'SPRIBE', 'fallback' => ['table' => 'games', 'provider' => 'PR', 'category' => 'LC']],
        ],
        'IBC' => [
            ['api' => 'SPORTSBOOK', 'fallback' => ['table' => 'games', 'provider' => 'IB', 'category' => 'SB']],
        ],
    ];

    public function category(string $slug)
    {
        abort_unless(isset(self::CATEGORY_PROVIDERS[$slug]), 404);

        return view('slots.games', [
            'title' => strtoupper(str_replace('-', ' ', $slug)),
            'game' => $this->loadMany(self::CATEGORY_PROVIDERS[$slug]),
        ]);
    }

    public function slots()
    {
        $providers = $this->loadProviders()
            ->filter(fn ($provider) => strtolower((string) ($provider->type ?? '')) === 'slot')
            ->map(fn ($provider) => $this->normalizeProviderCard($provider))
            ->values();

        if ($providers->isEmpty()) {
            $providers = $this->fallbackSlotProviders();
        }

        return view('slots.provider', compact('providers'));
    }

    public function slotProvider(string $slug)
    {
        $provider = $this->resolveProviderCode($slug);
        abort_unless($provider, 404);

        return view('slots.games', [
            'title' => strtoupper(str_replace(['-', '_'], ' ', $slug)),
            'game' => $this->loadOne(['api' => $provider, 'fallback' => $this->fallbackForProvider($provider)]),
        ]);
    }

    private function loadMany(array $providers): Collection
    {
        return collect($providers)
            ->flatMap(fn (array $provider) => $this->loadOne($provider))
            ->values();
    }

    private function loadOne(array $provider): Collection
    {
        $apiGames = $this->loadFromApi($provider['api']);

        if ($apiGames->isNotEmpty()) {
            return $apiGames;
        }

        return $this->loadFallback($provider['fallback']);
    }

    private function loadFromApi(string $provider): Collection
    {
        if (!$this->providerIsAvailable($provider)) {
            return collect();
        }

        $response = Cache::remember("ggr.game_list.{$provider}", now()->addMinutes(5), function () use ($provider) {
            try {
                return json_decode((new fiver())->gamelist($provider), true);
            } catch (\Throwable $exception) {
                Log::warning('Game API request failed', ['provider' => $provider, 'error' => $exception->getMessage()]);
                return null;
            }
        });

        if (!is_array($response)) {
            return collect();
        }

        $items = $response['gamelist'] ?? $response['game_list'] ?? $response['games'] ?? $response['data'] ?? [];

        if (!is_array($items) || empty($items)) {
            Log::warning('Game API returned no usable data', [
                'provider' => $provider,
                'status' => $response['status'] ?? null,
                'code' => $response['code'] ?? null,
                'message' => $response['message'] ?? $response['msg'] ?? null,
            ]);
            return collect();
        }

        return collect($items)
            ->map(fn ($game) => $this->normalizeApiGame((array) $game, $provider))
            ->filter(fn ($game) => $game->game_name && $game->game_provider && (int) $game->status === 1)
            ->values();
    }

    private function normalizeApiGame(array $game, string $provider): object
    {
        $code = (string) ($game['game_code'] ?? $game['gameCode'] ?? $game['code'] ?? $game['id'] ?? '');
        $name = (string) ($game['game_name'] ?? $game['gameName'] ?? $game['name'] ?? $code);
        $image = (string) ($game['banner'] ?? $game['game_image'] ?? $game['gameImage'] ?? $game['image'] ?? $game['img'] ?? '');

        return (object) [
            'id' => 'api-' . Str::slug($provider . '-' . ($code ?: 'lobby')),
            'game_code' => $code,
            'game_name' => $name,
            'game_provider' => (string) ($game['game_provider'] ?? $game['provider_code'] ?? $game['providerCode'] ?? $provider),
            'game_category' => (string) ($game['game_type'] ?? $game['game_category'] ?? $game['type'] ?? ''),
            'game_image' => $image,
            'status' => (int) ($game['status'] ?? 1),
            'launch_key' => 'api:' . rawurlencode($provider) . ':' . rawurlencode($code),
        ];
    }

    private function loadFallback(array $fallback): Collection
    {
        $query = DB::table($fallback['table'])->where('game_provider', $fallback['provider']);

        if (!empty($fallback['category'])) {
            $query->where('game_category', $fallback['category']);
        }

        return $query->get()->map(function ($game) {
            $game->launch_key = (string) $game->id;
            $game->status = (int) ($game->status ?? 1);
            return $game;
        });
    }

    private function loadProviders(): Collection
    {
        $response = Cache::remember('ggr.provider_list', now()->addMinutes(10), function () {
            try {
                return json_decode((new fiver())->providerlist(), true);
            } catch (\Throwable $exception) {
                Log::warning('Provider API request failed', ['error' => $exception->getMessage()]);
                return null;
            }
        });

        if (!is_array($response) || (int) ($response['status'] ?? 0) !== 1 || empty($response['providers'])) {
            Log::warning('Provider API returned no usable data', [
                'status' => $response['status'] ?? null,
                'message' => $response['message'] ?? $response['msg'] ?? null,
            ]);
            return collect();
        }

        return collect($response['providers'])
            ->map(fn ($provider) => (object) $provider)
            ->filter(fn ($provider) => !empty($provider->code) && (int) ($provider->status ?? 0) === 1)
            ->values();
    }

    private function normalizeProviderCard(object $provider): object
    {
        $code = (string) $provider->code;
        $fallback = $this->fallbackForProvider($code);
        $query = DB::table($fallback['table'])->where('game_provider', $fallback['provider']);

        if (!empty($fallback['category'])) {
            $query->where('game_category', $fallback['category']);
        }

        $sample = (clone $query)->select('game_image')->whereNotNull('game_image')->first();

        return (object) [
            'slug' => Str::slug($code),
            'name' => (string) ($provider->name ?? $code),
            'api_provider' => $code,
            'url' => url('/slots/game_list/' . Str::slug($code)),
            'image' => $sample->game_image ?? asset('images/default-bank.svg'),
            'count' => (clone $query)->count(),
        ];
    }

    private function resolveProviderCode(string $slug): ?string
    {
        $normalized = Str::slug($slug);
        $legacy = self::LEGACY_SLUG_MAP[$normalized] ?? self::LEGACY_SLUG_MAP[$slug] ?? null;

        $providers = $this->loadProviders();
        $availableCodes = $providers->pluck('code')->map(fn ($code) => (string) $code);

        if ($legacy && $availableCodes->contains($legacy)) {
            return $legacy;
        }

        $matched = $availableCodes
            ->first(fn ($code) => Str::slug($code) === $normalized || strtolower($code) === strtolower($slug));

        return $matched ?: $legacy;
    }

    private function providerIsAvailable(string $provider): bool
    {
        $providers = $this->loadProviders();

        if ($providers->isEmpty()) {
            return true;
        }

        return $providers->contains(fn ($item) => (string) $item->code === $provider && (int) ($item->status ?? 0) === 1);
    }

    private function fallbackForProvider(string $provider): array
    {
        return self::FALLBACK_BY_PROVIDER[$provider] ?? [
            'table' => 'fiver_games',
            'provider' => $provider,
            'category' => 'slot',
        ];
    }

    private function fallbackSlotProviders(): Collection
    {
        return collect(self::LEGACY_SLUG_MAP)
            ->unique()
            ->map(function (string $provider) {
                $fallback = $this->fallbackForProvider($provider);
                $query = DB::table($fallback['table'])->where('game_provider', $fallback['provider']);
                $sample = (clone $query)->select('game_image')->whereNotNull('game_image')->first();

                return (object) [
                    'slug' => Str::slug($provider),
                    'name' => $provider,
                    'api_provider' => $provider,
                    'url' => url('/slots/game_list/' . Str::slug($provider)),
                    'image' => $sample->game_image ?? asset('images/default-bank.svg'),
                    'count' => (clone $query)->count(),
                ];
            })
            ->values();
    }
}
