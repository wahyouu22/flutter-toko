<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Hanya izinkan metode yang umum digunakan
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Izinkan hanya asal tertentu
    'allowed_origins' => [
        'http://127.0.0.1',
    ],

    // Izinkan pola wildcard domain seperti *.rajaongkir.com
    'allowed_origins_patterns' => [
        '^https?:\/\/([a-z0-9-]+\.)*rajaongkir\.com$',
    ],

    // Hanya header yang diperlukan
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'Origin',
    ],

    'exposed_headers' => [],

    // Cache preflight response selama 1 jam
    'max_age' => 3600,

    // Tidak mendukung kredensial untuk keamanan lebih ketat
    'supports_credentials' => false,

];
