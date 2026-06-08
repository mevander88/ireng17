<?php

return [
    'merchant_code' => env('JAYAPAY_MERCHANT_CODE'),
    'private_key'   => env('JAYAPAY_PRIVATE_KEY'),
    'private_key_path' => env('JAYAPAY_PRIVATE_KEY_PATH', 'storage/app/private_pkcs8.pem'),
    'public_key'    => env('JAYAPAY_PUBLIC_KEY'),
    'api_url'       => env('JAYAPAY_API_URL', 'https://openapi.jayapayment.com/gateway/prepaidOrder'),
    'notify_url'    => env('JAYAPAY_NOTIFY_URL'),
];
