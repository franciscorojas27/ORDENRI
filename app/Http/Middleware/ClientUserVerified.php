<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientUserVerified
{
    /**
     * Verifica si el usuario logueado es un cliente y redirige a la pagina de ordenes en caso de serlo.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        // if ($request->user()->Jobtitle->title === 'Cliente') {
        //     return redirect()->route('order.index');
        // }
        if(!$request->user()->isClient()) {
            return $next($request);
        }
        return redirect()->route('order.index');
    }
}
