<?php

namespace App\Http\Controllers;

use App\Services\GgrCatalogService;
use App\Models\Setting;
use Illuminate\Http\Request;

class GgrSiteController extends Controller
{
    public function __construct(private readonly GgrCatalogService $catalog)
    {
    }

    public function home()
    {
        $this->bootstrapCatalog();
        $popularSlotGames = $this->catalog->popularSlotGames(24);

        return view('ggr.home', [
            'setting' => Setting::first(),
            'slotProviders' => $this->catalog->providers('slot'),
            'liveProviders' => $this->catalog->providers('live'),
            'miniProviders' => $this->catalog->providers('MN'),
            'sportsProviders' => $this->catalog->providers('SB'),
            'featuredGames' => $popularSlotGames->isNotEmpty() ? $popularSlotGames : $this->catalog->featuredGames(18),
            'homeBanners' => $this->homeBanners(),
        ]);
    }

    public function providers(?string $type = null)
    {
        $this->bootstrapCatalog();

        return view('ggr.providers', [
            'setting' => Setting::first(),
            'type' => $type,
            'providers' => $this->catalog->providers($type),
        ]);
    }

    public function providerGames(Request $request, string $slug)
    {
        $this->bootstrapCatalog();

        $provider = $this->catalog->providerBySlug($slug);
        abort_unless($provider, 404);

        $games = $this->catalog->gamesForProvider($provider->code, $request->query('q'));

        if ($games->isEmpty()) {
            $this->catalog->syncGames($provider->code);
            $games = $this->catalog->gamesForProvider($provider->code, $request->query('q'));
        }

        return view('ggr.games', [
            'setting' => Setting::first(),
            'provider' => $provider,
            'games' => $games,
            'query' => $request->query('q', ''),
        ]);
    }

    private function bootstrapCatalog(): void
    {
        if ($this->catalog->providers()->isEmpty()) {
            $this->catalog->syncProviders();
            $this->catalog->syncGames(null, 6);
        }
    }

    private function homeBanners(): array
    {
        $directory = public_path('assets/images/home-banners');

        if (! is_dir($directory)) {
            return [];
        }

        return collect(glob($directory . DIRECTORY_SEPARATOR . '*.webp') ?: [])
            ->sort()
            ->values()
            ->map(fn (string $path): string => asset('assets/images/home-banners/' . basename($path)))
            ->all();
    }
}
