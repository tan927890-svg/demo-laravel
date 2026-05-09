<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(\App\Http\Middleware\DynamicSession::class);
        $middleware->trustProxies(at: '*');
        $middleware->encryptCookies(except: []);
        $middleware->alias([
            'role'           => \App\Http\Middleware\RoleMiddleware::class,
            'office.network' => \App\Http\Middleware\OfficeNetwork::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'bao-gia-nhanh',
            'bao-gia-nhanh/*',
            'login',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();