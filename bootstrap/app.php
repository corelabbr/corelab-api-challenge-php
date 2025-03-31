<?php

declare(strict_types = 1);

use App\Http\Middleware\EnsureApiToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->alias([
        //     'api.token' => EnsureApiToken::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (RouteNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
            ], 500);
        });
    })->create();
