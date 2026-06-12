<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\GgrGame;
use App\Models\GgrProvider;
use App\Models\Setting;

class GgrAmpController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return response()
            ->view('ggr.amp-index', [
                'setting' => $setting,
                'banner' => $this->banner(),
                'providers' => GgrProvider::query()
                    ->where('is_open', true)
                    ->withCount(['games' => fn ($query) => $query->where('is_open', true)])
                    ->orderByDesc('games_count')
                    ->limit(8)
                    ->get(),
                'games' => GgrGame::query()
                    ->where('is_open', true)
                    ->whereNotNull('banner')
                    ->where('banner', '<>', '')
                    ->orderByDesc('updated_at')
                    ->limit(8)
                    ->get(),
                'providerCount' => GgrProvider::where('is_open', true)->count(),
                'gameCount' => GgrGame::where('is_open', true)->count(),
            ])
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function banner(): ?string
    {
        $banner = Banner::query()
            ->where('status', '1')
            ->whereNotNull('gambar')
            ->where('gambar', '<>', '')
            ->latest()
            ->first();

        if ($banner) {
            return asset('storage/' . ltrim($banner->gambar, '/'));
        }

        $fallback = public_path('assets/images/home-banners/home-banner-01.webp');
        return is_file($fallback) ? asset('assets/images/home-banners/home-banner-01.webp') : null;
    }
}
