<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),

    // HANYA ANGKA
    'characters' => ['0','1','2','3','4','5','6','7','8','9'],

    'default' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'encrypt' => false,
    ],

    'math' => [
        'length' => 9,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => true,
    ],

    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 90,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50'],
        'contrast' => -5,
    ],

    'mini' => [
        'length' => 3,
        'width' => 120,
        'height' => 38,

        // MINI JUGA ANGKA SAJA
        'characters' => ['0','1','2','3','4','5','6','7','8','9'],
    ],

    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
