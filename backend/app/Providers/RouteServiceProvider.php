<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\AdminApi\Controllers\UsersController;
use App\Http\AdminApi\Controllers\UsersPaymentsController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('users')->group(function (): void {
                Route::get('', [UsersController::class, 'index']);
                Route::get('{user}', [UsersController::class, 'show']);
                Route::post('', [UsersController::class, 'store']);
                Route::delete('{user}', [UsersController::class, 'destroy']);
                Route::get('{user}/payments', [UsersPaymentsController::class, 'index']);
            });
        });
    }
}
