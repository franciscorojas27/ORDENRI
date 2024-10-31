<?php

namespace App\Providers;

use App\Models\User;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Listeners\SendOrderConfirmation;
use Illuminate\Cache\RateLimiting\Limit;
use App\Exceptions\CustomThrottleException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Validation\ValidationException;
use Illuminate\Queue\Middleware\ThrottlesExceptions;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        RateLimiter::for('limit-login', function (Request $request) {
            return Limit::perDay(env('LOGIN_MAX_ATTEMPTS'))->by($request->user() ? $request->user()->id : $request->ip());
        });
        RateLimiter::for('limit-login', function (Request $request) {
            return Limit::perDay(env('LOGIN_MAX_ATTEMPTS'))
                ->by($request->user() ? $request->user()->id : $request->ip())
                ->response(function (Request $request, array $headers) {
                    if ($request->user()) {
                        $request->user()->update(['last_login_at' => now()]);
                        Cache::tags(['user-'.$request->user()->id])->flush();
                    }
                    throw ValidationException::withMessages([
                        'email' => trans('auth.throttle'),
                    ]);
                });
        });
        
    }   
}
