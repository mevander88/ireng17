<?php

namespace App\Console\Commands;

use App\Models\GgrGame;
use App\Models\GgrProvider;
use App\Support\ImageCache;
use Illuminate\Console\Command;

class CacheRemoteImages extends Command
{
    protected $signature = 'images:cache-remote {--limit=300}';
    protected $description = 'Fetch remote provider and game images into the local image cache.';

    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $urls = collect();

        GgrProvider::with('coverGame')->limit($limit)->get()->each(function (GgrProvider $provider) use ($urls) {
            if ($provider->coverGame?->banner) {
                $urls->push($provider->coverGame->banner);
            }
        });

        GgrGame::whereNotNull('banner')
            ->where('banner', '<>', '')
            ->limit($limit)
            ->pluck('banner')
            ->each(fn ($url) => $urls->push($url));

        $count = 0;
        foreach ($urls->unique()->values() as $url) {
            if (ImageCache::getOrFetch((string) $url)) {
                $count++;
            }
        }

        $this->info("Cached {$count} remote images.");

        return self::SUCCESS;
    }
}
