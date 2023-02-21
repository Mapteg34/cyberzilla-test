<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAuthGuardMiddleware
{
    private Factory $auth;

    public function __construct(Factory $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next, string $guard): Response
    {
        $this->getAuth()->shouldUse($guard);

        return $next($request);
    }

    public function getAuth(): Factory
    {
        return $this->auth;
    }
}
