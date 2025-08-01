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
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'super_admin' => \App\Http\Middleware\EnsureUserIsSuperAdmin::class,
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
          ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
