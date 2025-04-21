<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Services\ApiResponse\Facades\ApiResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->throttleWithRedis();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            return ApiResponse::withStatus(404)->withMessage('not found !!')->send();
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $exception) {
            return ApiResponse::withStatus(404)->withAppends($exception->errors())->send();
        });

        $exceptions->shouldRenderJsonWhen(function (\Illuminate\Http\Request $request){
            return true;
        });
    })->create();
