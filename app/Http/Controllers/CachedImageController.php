<?php

namespace App\Http\Controllers;

use App\Support\ImageCache;
use Illuminate\Http\Request;

class CachedImageController extends Controller
{
    public function show(string $hash, Request $request)
    {
        $encoded = (string) $request->query('u', '');

        if (!ImageCache::validSignature($hash, $encoded, $request->query('s'))) {
            abort(403);
        }

        $url = base64_decode($encoded, true);
        if (!$url || sha1($url) !== $hash || !preg_match('/^https?:\/\//i', $url)) {
            abort(404);
        }

        $meta = ImageCache::getOrFetch($url);
        if (!$meta) {
            return redirect()->away($url);
        }

        return redirect()->away(ImageCache::publicUrl($meta), 302, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
