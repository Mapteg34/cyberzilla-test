<?php

return [

    'defaults' => [
        'guard' => 'admin_guard',
        'passwords' => 'users',
    ],

    'guards' => [
        'admin_guard' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
];
