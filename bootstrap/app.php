<?php

use App\Exceptions\PaymentException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetJsonRequestHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([
            PaymentException::class,
        ]);

        $exceptions->render(function (PaymentException $e, Request $request) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        });
    })->create();
