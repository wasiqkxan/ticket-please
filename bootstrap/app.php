<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        // Default API routes
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Versioned API routes
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api_v1.php'));

        // Web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Console routes
        Route::group([], function () {
            require base_path('routes/console.php');
        });

        // Health check route
        Route::get('/up', function () {
            return response()->json(['status' => 'ok']);
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Define your middleware here
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Define your exception handling here
    })->create();