<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\ClientUserVerified;
use App\Http\Middleware\AdminUserVerification;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\RedirectIfOrderNotFound;
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
        $middleware->alias(['clientVerified' => ClientUserVerified::class])->alias(['order.check' => RedirectIfOrderNotFound::class])->alias(['adminUserVerification' => AdminUserVerification::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Uncomment and modify as needed
        // $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
        //     // Create a ValidationException with a custom message
        //     $exception = ValidationException::withMessages([
        //         'email' => trans('auth.throttle_block'),
        //     ]);

        //     // Clear the rate limit for the user's IP address
        //     RateLimiter::clear('limit-login:' . $request->ip());
            
        //     // Throw the customized exception
        //     throw $exception; 
        // });
    })
    ->create();
