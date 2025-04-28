<?php

return [

    'defaults' => [
        'guard' => 'customer', // Default tetap customer (untuk frontend/public)
        'passwords' => 'customers',
    ],

    'guards' => [
        'customer' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],

        'user' => [ // Tambahkan guard untuk admin (tabel users)
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],

        'users' => [ // Tambahkan provider untuk admin
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'customers' => [
            'provider' => 'customers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'users' => [ // Opsional, kalau butuh fitur reset password untuk admin
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
