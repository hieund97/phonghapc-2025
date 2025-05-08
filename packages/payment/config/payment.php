<?php

return [
    'alepay' => [
        'api_url' => env('ALEPAY_API_URL', 'https://alepay.vn'),
        'checksum_key' => env('ALEPAY_CHECKSUM_KEY'),
        'encrypt_key' => env('ALEPAY_ENCRYPT_KEY'),
        'token_key' => env('ALEPAY_TOKEN_KEY'),
    ],
];
