<?php

use App\Exceptions\ApiValidationHandler;
use App\Exceptions\ExistsResourceHandler;
use App\Exceptions\NotFoundHandler;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            // \Illuminate\Http\Middleware\TrustHosts::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException|NotFoundException|BadRequestHttpException $e, $request) {
            if ($request->expectsJson()) {
                if ($e instanceof ValidationException) {
                    return ApiValidationHandler::handle($e, $request);
                } elseif ($e instanceof NotFoundException) {
                    return NotFoundHandler::handle($e, $request);
                } elseif ($e instanceof BadRequestHttpException) {
                    return ExistsResourceHandler::handle($e, $request);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Status unknown.',
                        'error' => $e->getMessage(),
                        'code'    => 500,
                    ], 500);
                }
            }
        });
    })->create();
