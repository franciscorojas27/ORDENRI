<?php

use Illuminate\Foundation\Application;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
            // $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
            //     $exception = ValidationException::withMessages([
            //         'email' => trans('auth.throttle_block'),
            //     ]);
            //     RateLimiter::clear('limit-login:' . $request->ip());
            //     throw $exception; 
            // });
    })->create();
