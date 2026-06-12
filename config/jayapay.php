<?php

return [
    'merchant_code' => env('TOPPAYMENT_MERCHANT_CODE', env('JAYAPAY_MERCHANT_CODE')),
    'private_key' => env('JAYAPAY_PRIVATE_KEY'),
    'private_key_path' => env('TOPPAYMENT_PRIVATE_KEY_PATH', env('JAYAPAY_PRIVATE_KEY_PATH', 'storage/app/toppayment_private.pem')),
    'public_key' => env('JAYAPAY_PUBLIC_KEY'),
    'public_key_path' => env('TOPPAYMENT_PUBLIC_KEY_PATH', env('JAYAPAY_PUBLIC_KEY_PATH', 'storage/app/toppayment_public.pem')),
    'api_url' => env('TOPPAYMENT_API_URL', env('JAYAPAY_API_URL', 'https://global-id-openapi.toppayment.com/id/pay/prePay')),
    'query_url' => env('TOPPAYMENT_QUERY_URL', env('JAYAPAY_QUERY_URL', 'https://global-id-openapi.toppayment.com/id/pay/query')),
    'notify_url' => env('TOPPAYMENT_NOTIFY_URL', env('JAYAPAY_NOTIFY_URL')),
    'ca_bundle_path' => env('TOPPAYMENT_CA_BUNDLE_PATH', env('JAYAPAY_CA_BUNDLE_PATH', 'storage/app/cacert.pem')),
];
