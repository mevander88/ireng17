<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerPromosi;
use App\Services\GgrCatalogService;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class GgrSiteController extends Controller
{
    public function __construct(private readonly GgrCatalogService $catalog)
    {
    }

    public function home()
    {
        $this->bootstrapCatalog();
        $popularSlotGames = $this->catalog->popularSlotGames(16);

        return view('ggr.home', [
            'setting' => Setting::first(),
            'slotProviders' => $this->catalog->providers('slot'),
            'liveProviders' => $this->catalog->providers('live'),
            'miniProviders' => $this->catalog->providers('MN'),
            'sportsProviders' => $this->catalog->providers('SB'),
            'featuredGames' => $popularSlotGames->isNotEmpty() ? $popularSlotGames : $this->catalog->featuredGames(16),
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

    public function promotion()
    {
        return view('promotion', [
            'banners' => BannerPromosi::all(),
        ]);
    }

    public function notFound()
    {
        abort(404);
    }

    public function usernamePhone(Request $request)
    {
        $username = base64_decode((string) $request->query('username', ''), true);
        $phone = base64_decode((string) $request->query('phone', ''), true);

        if ($username === false || $phone === false) {
            return response()->json([
                'username' => false,
                'phone' => false,
            ], 400);
        }

        return response()->json([
            'username' => ! User::where('name', $username)->exists(),
            'phone' => ! User::where('telp', $phone)->exists(),
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
        $databaseBanners = Banner::query()
            ->where('status', '1')
            ->whereNotNull('gambar')
            ->where('gambar', '<>', '')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (Banner $banner): string => asset('storage/' . ltrim($banner->gambar, '/')))
            ->all();

        if ($databaseBanners !== []) {
            return $databaseBanners;
        }

        $directory = public_path('assets/images/home-banners');

        if (! is_dir($directory)) {
            return [];
        }

        return collect(glob($directory . DIRECTORY_SEPARATOR . '*.webp') ?: [])
            ->sort()
            ->values()
            ->take(5)
            ->map(fn (string $path): string => asset('assets/images/home-banners/' . basename($path)))
            ->all();
    }
}
