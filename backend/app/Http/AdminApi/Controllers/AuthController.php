<?php

declare(strict_types=1);

namespace App\Http\AdminApi\Controllers;

use App\Exceptions\ValidationException;
use App\Http\AbstractController;
use App\Http\AdminApi\Requests\AuthenticatedRequest;
use App\Http\AdminApi\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use RuntimeException;

class AuthController extends AbstractController
{
    public function __construct()
    {
        $this->middleware('guest')->only([
            'login',
        ]);
        $this->middleware('auth')->only([
            'user',
        ]);
    }

    public function login(LoginRequest $request, Guard $guard): JsonResponse
    {
        if (! ($guard instanceof JWTGuard)) {
            throw new RuntimeException('Invalid guard');
        }

        $credentials = $request->validated();

        if (! method_exists($guard, 'attempt')) {
            throw new RuntimeException('Unsupported guard');
        }

        if (! $guard->attempt($credentials)) {
            throw new ValidationException(['email' => ['Invalid credentials']]);
        }

        /** @var User $user */
        $user = $guard->user();

        $token = $guard->refresh(true);

        return (new JsonResponse(['data' => $user]))->header('Authorization', sprintf('Bearer %s', $token));
    }

    public function refresh(Guard $guard): JsonResponse
    {
        if (! ($guard instanceof JWTGuard)) {
            throw new RuntimeException('Invalid guard');
        }

        $token = $guard->refresh(true);

        $guard->setToken($token);

        return (new JsonResponse([]))->header('Authorization', sprintf('Bearer %s', $token));
    }

    public function user(AuthenticatedRequest $request): JsonResponse
    {
        return new JsonResponse(['data' => $request->user()]);
    }
}
