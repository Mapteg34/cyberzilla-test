<?php

declare(strict_types=1);

// Мы активно используем jwt-аутентификацию
//
// Со стороны лары нам помогает https://github.com/tymondesigns/jwt-auth (https://jwt-auth.readthedocs.io/en/develop/)
//
// Токен генерируется асинхронным алгоритмом, ключи лежат в репо.
// Генерируются ключи вручную, например через https://travistidwell.com/jsencrypt/demo/ (key size - 1024, algo - RS256).
// Или с помощью
// $ ssh-keygen -t rsa -b 2048 -m PEM -f private.pem -N "" && \
//   rm private.pem.pub && \
//   openssl rsa -in private.pem -pubout -outform PEM -out public.pem
//
// Токен создается приватным ключем на стороне laravel.
//
// Токен выдается на 24часа.
// После исхода 24 часов он становится невалиден, однако его можно "обновить" еще 2недели после истечения.
return [
    'secret' => env('JWT_SECRET'),
    'keys' => [
        'public' => env('JWT_PUBLIC_KEY'),
        'private' => env('JWT_PRIVATE_KEY'),
        'passphrase' => env('JWT_PASSPHRASE'),
    ],

    'ttl' => env('JWT_TTL', 60),
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),
    'algo' => env('JWT_ALGO', 'RS256'),
    'required_claims' => [
        'iss',
        'iat',
        'exp',
        'nbf',
        'sub',
        'jti',
    ],
    'persistent_claims' => [
        // 'foo',
        // 'bar',
    ],
    'lock_subject' => true,
    'leeway' => env('JWT_LEEWAY', 0),
    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', false),
    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),
    'show_black_list_exception' => env('JWT_SHOW_BLACKLIST_EXCEPTION', 0),

    'decrypt_cookies' => false,

    'providers' => [
        'jwt' => PHPOpenSourceSaver\JWTAuth\Providers\JWT\Lcobucci::class,
        'auth' => PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate::class,
        'storage' => PHPOpenSourceSaver\JWTAuth\Providers\Storage\Illuminate::class,
    ],
];
