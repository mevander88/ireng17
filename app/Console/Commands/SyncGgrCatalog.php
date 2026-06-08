<?php

namespace App\Console\Commands;

use App\Services\GgrCatalogService;
use Illuminate\Console\Command;

class SyncGgrCatalog extends Command
{
    protected $signature = 'ggr:sync-catalog {--provider=} {--limit=30}';

    protected $description = 'Sync GGR providers and games into local catalog tables.';

    public function handle(GgrCatalogService $catalog): int
    {
        $provider = $this->option('provider') ?: null;
        $limit = max(1, (int) $this->option('limit'));

        if ($provider === null) {
            $providerResult = $catalog->syncProviders();
            $providerCount = $providerResult['synced'] ?? 0;
            $this->info("Synced {$providerCount} providers.");
        }

        $result = $catalog->syncGames($provider, $limit);

        foreach ($result as $providerCode => $row) {
            $status = $row['ok'] ? 'OK' : 'ERR';
            $count = $row['synced'] ?? 0;
            $message = $row['message'] ?? '';
            $this->line("{$status} {$providerCode} {$count} {$message}");
        }

        return self::SUCCESS;
    }
}
