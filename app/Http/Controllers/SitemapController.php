<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        // Daftar URL yang ingin dimasukkan ke sitemap
        $urls = [
            URL::to('/'),
            URL::to('/slots'),
            URL::to('/casino'),
            URL::to('/sports'),
            URL::to('/e-games'),
            URL::to('/promotion'),
            URL::to('/register'),
            URL::to('/amp.html'),
        ];

        // Render view sitemap.blade.php dengan data $urls
        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
