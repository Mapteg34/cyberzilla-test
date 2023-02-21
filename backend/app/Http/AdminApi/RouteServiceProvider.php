<?php

declare(strict_types=1);

namespace App\Http\AdminApi;

use App\Enums\RouteGroupEnum;
use App\Http\AdminApi\Controllers\AuthController;
use App\Http\AdminApi\Controllers\UsersController;
use App\Http\AdminApi\Controllers\UsersPaymentsController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('admin-api')->middleware(RouteGroupEnum::ADMIN_API->value)->group(function (): void {
                Route::prefix('auth')->group(function (): void {
                    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
                    Route::get('refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
                    Route::get('user', [AuthController::class, 'user'])->name('auth.user');
                });

                Route::middleware('auth')->group(function (): void {
                    Route::apiResource('users', UsersController::class)->except(['edit']);
                    Route::get('users/{user}/payments', [UsersPaymentsController::class, 'index']);
                });
            });
        });
    }
}
