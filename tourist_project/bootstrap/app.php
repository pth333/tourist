<?php

use App\Http\Middleware\AuthenicationMiddleware;
use App\Http\Middleware\QuantityLimitPerson;
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
        $middleware->alias([
            'auth' => AuthenicationMiddleware::class,
            // 'client.session' => ClientSession::class,
            'limit' => QuantityLimitPerson::class,
        ]);
        $middleware->validateCsrfTokens(except:[
            'chatbot/webhook'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
