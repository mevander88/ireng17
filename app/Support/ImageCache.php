<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImageCache
{
    private const DIR = 'image-cache';
    private const TTL_DAYS = 14;

    public static function url(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (!preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }

        if (!self::isAllowedRemoteUrl($url)) {
            return $url;
        }

        $meta = self::metadata($url);
        if (self::hasFreshFile($meta)) {
            return url('/image-cache/' . basename((string) $meta['path']));
        }

        $hash = sha1($url);
        $encoded = base64_encode($url);
        $signature = hash_hmac('sha256', $hash . '|' . $encoded, config('app.key'));

        return url("/cached-image/{$hash}") . '?u=' . rawurlencode($encoded) . '&s=' . $signature;
    }

    public static function metadata(string $url): array
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $extension = 'jpg';
        }

        return [
            'hash' => sha1($url),
            'path' => self::DIR . '/' . sha1($url) . '.' . $extension,
        ];
    }

    public static function publicUrl(array $meta): string
    {
        return url('/image-cache/' . basename((string) $meta['path']));
    }

    public static function getOrFetch(string $url): ?array
    {
        if (!self::isAllowedRemoteUrl($url)) {
            Log::warning('Image cache rejected unsafe URL', ['url' => $url]);
            return null;
        }

        $meta = self::metadata($url);
        if (self::hasFreshFile($meta)) {
            return $meta;
        }

        try {
            $request = Http::timeout(8)
                ->retry(1, 250)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 ireng17 image cache']);

            if (!config('services.provider_ssl_verify', true)) {
                $request = $request->withoutVerifying();
            }

            $response = $request->get($url);

            if (!$response->ok()) {
                Log::warning('Image cache fetch failed', ['url' => $url, 'status' => $response->status()]);
                return null;
            }

            $contentType = strtolower((string) $response->header('Content-Type'));
            if (!str_starts_with($contentType, 'image/') || str_contains($contentType, 'svg')) {
                Log::warning('Image cache rejected non-bitmap response', ['url' => $url, 'content_type' => $contentType]);
                return null;
            }

            $body = $response->body();
            $maxBytes = max(1, (int) config('services.image_cache_max_bytes', 5 * 1024 * 1024));
            if (strlen($body) > $maxBytes) {
                Log::warning('Image cache rejected oversized response', ['url' => $url, 'bytes' => strlen($body), 'max_bytes' => $maxBytes]);
                return null;
            }

            File::ensureDirectoryExists(dirname(self::absolutePath($meta)));
            File::put(self::absolutePath($meta), $body);

            return $meta;
        } catch (\Throwable $e) {
            Log::warning('Image cache exception', ['url' => $url, 'message' => $e->getMessage()]);
            return null;
        }
    }

    private static function hasFreshFile(array $meta): bool
    {
        $path = self::absolutePath($meta);

        if (!File::exists($path)) {
            return false;
        }

        $modified = File::lastModified($path);
        return $modified >= now()->subDays(self::TTL_DAYS)->getTimestamp();
    }

    private static function absolutePath(array $meta): string
    {
        return storage_path('app/' . ltrim((string) $meta['path'], '/\\'));
    }

    public static function validSignature(string $hash, string $encoded, ?string $signature): bool
    {
        if (!$signature) {
            return false;
        }

        return hash_equals(hash_hmac('sha256', $hash . '|' . $encoded, config('app.key')), $signature);
    }

    private static function isAllowedRemoteUrl(string $url): bool
    {
        $parts = parse_url($url);
        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = strtolower((string) ($parts['host'] ?? ''));

        if (!in_array($scheme, ['http', 'https'], true) || $host === '') {
            return false;
        }

        $allowedHosts = (array) config('services.image_cache_allowed_hosts', []);
        if ($allowedHosts !== [] && !in_array($host, $allowedHosts, true)) {
            return false;
        }

        if (in_array($host, ['localhost', 'localhost.localdomain'], true) || str_ends_with($host, '.local')) {
            return false;
        }

        $ips = filter_var($host, FILTER_VALIDATE_IP) ? [$host] : (dns_get_record($host, DNS_A + DNS_AAAA) ?: []);
        if ($ips === []) {
            return false;
        }

        foreach ($ips as $record) {
            $ip = is_string($record) ? $record : ($record['ip'] ?? $record['ipv6'] ?? null);
            if (!$ip || !self::isPublicIp($ip)) {
                return false;
            }
        }

        return true;
    }

    private static function isPublicIp(string $ip): bool
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }
}
