<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOnlyMiddleware
{
    /** @throws AuthenticationException */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! empty($user)) {
            throw new AuthenticationException('Guest only');
        }

        return $next($request);
    }
}
