<?php

declare(strict_types=1);

namespace App\Http;

use App\Enums\RouteGroupEnum;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\GuestOnlyMiddleware::class,
        'setAuthGuard' => \App\Http\Middleware\SetAuthGuardMiddleware::class,
    ];

    public function __construct(Application $app, Router $router)
    {
        $this->middlewareGroups = [
            RouteGroupEnum::ADMIN_API->value => [
                'setAuthGuard:admin_guard',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
        ];

        parent::__construct($app, $router);
    }
}
