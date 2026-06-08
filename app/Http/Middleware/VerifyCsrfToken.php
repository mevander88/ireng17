<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'jayapay/callback', // ✅ Callback dari Jayapay (tanpa slash awal)
        'api/jayapay/callback', // ✅ Jika callback diarahkan ke route API
    ];
}
