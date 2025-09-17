<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Sanctum middleware for handling SPA / API auth
        $middleware->group('web', [
            // EnsureFrontendRequestsAreStateful::class, // Removed Sanctum middleware
        ]);

        // CSRF protection removed from API routes except login
        $middleware->group('api', [
            // EnsureFrontendRequestsAreStateful::class, // Removed for all API routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
