<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->redirectUsersTo('/api/home');
        $middleware->trustHosts(at: function () {
            return explode(',', env('SANCTUM_STATEFUL_DOMAINS'));
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
