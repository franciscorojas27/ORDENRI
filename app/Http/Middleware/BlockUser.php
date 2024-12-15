<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BlockUser
{
    /**
     * Maneja una solicitud entrante y verifica si el usuario esta bloqueado o eliminado, en cuyo caso
     * se cierra la sesión y se redirige al login.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check()) {
        //     return $next($request);
        // }

        if ($request->user()->isBlocked() || $request->user()->isDeleted() || $request->user()->atValidate()) {
            Auth::logout();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
