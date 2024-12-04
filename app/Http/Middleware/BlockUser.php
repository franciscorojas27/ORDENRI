<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BlockUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Permite el acceso a rutas de invitados
        // if (!auth()->check()) {
        //     return $next($request);
        // }

        if ($request->user()->isBlocked() || $request->user()->isDeleted() || $request->user()->atValidate()) {
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
