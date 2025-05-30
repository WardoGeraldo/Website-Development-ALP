<?php

use App\Http\Middleware\CheckAuth;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckRoleMiddleWare;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'role'=>CheckRoleMiddleWare::class,
            'manual_auth'=>CheckAuth::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
