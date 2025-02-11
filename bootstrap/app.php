<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->query('debug') == 'true') {
                dd($e);
            }

            if ($request->is('api/')) {
                $statusCode = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : ($e->status ?? 500);
                return response()->json([
                    'success' => false,
                    'route' => $request->path(),
                    'verb' => $request->method(),
                    'message' => $e->getMessage(),

                ], $statusCode);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            $statusCode = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : ($e->status ?? 500);
            if ($request->is('api/')) {
                return response()->json([
                    'success' => false,
                    'route' => $request->path(),
                    'verb' => $request->method(),
                    'message' => $e->getMessage(),
                ], $statusCode);
            }
        });
    })->create();