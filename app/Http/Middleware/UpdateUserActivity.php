<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserActivity
{
    /**
     * Maneja una solicitud entrante y actualiza la ultima conexión del usuario a ahora y su estado de conexión a true.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(Auth::user()->id);
        $user->last_connection = now();
        $user->is_connected = true;
        $user->save();
        return $next($request);
    }
}
