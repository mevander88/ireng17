<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'provider_ssl_verify' => env('PROVIDER_SSL_VERIFY', true),

    'ggr' => [
        'api_url' => env('GGR_API_URL'),
        'agent_code' => env('GGR_AGENT_CODE'),
        'agent_token' => env('GGR_AGENT_TOKEN'),
    ],

    'image_cache_max_bytes' => (int) env('IMAGE_CACHE_MAX_BYTES', 5 * 1024 * 1024),
    'image_cache_allowed_hosts' => array_values(array_filter(array_map(
        static fn ($host) => strtolower(trim($host)),
        explode(',', (string) env('IMAGE_CACHE_ALLOWED_HOSTS', ''))
    ))),

    'lucky_spin_prizes' => array_values(array_filter(array_map(
        static fn ($amount) => (int) trim($amount),
        explode(',', (string) env('LUCKY_SPIN_PRIZES', ''))
    ))),

];
