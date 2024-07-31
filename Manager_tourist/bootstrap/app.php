<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminSession;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
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
            'admin' => Admin::class,
            'auth' => Authenticate::class,
            'verified' => EnsureEmailIsVerified::class,
            'admin.session' => AdminSession::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
