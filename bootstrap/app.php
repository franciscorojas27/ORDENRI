<?php

use Illuminate\Http\Request;
use App\Http\Middleware\BlockUser;
use App\Http\Middleware\BlockAnalyzer;
use Illuminate\Foundation\Application;
use App\Http\Middleware\ClientUserVerified;
use App\Http\Middleware\UpdateUserActivity;
use App\Http\Middleware\AdminUserVerification;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\RedirectIfOrderNotFound;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'clientVerified' => ClientUserVerified::class,
            'adminUserVerification' => AdminUserVerification::class,
            'order.check' => RedirectIfOrderNotFound::class,
            'updateUserActivity' => UpdateUserActivity::class,
            'blockAnalyzer' => BlockAnalyzer::class,
            'validatedUser' => BlockUser::class
        ]);
        $middleware->redirectUsersTo('/orders');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 
    })
    ->create();
