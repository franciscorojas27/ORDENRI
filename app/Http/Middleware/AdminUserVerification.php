<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserVerification
{
    /**
     * Verifica si el usuario tiene el rol de administrador y redirige a una pagina de error en caso de no tenerlo.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        
        if (!request()->user()->hasRole('Administrador')) {
            return response()->redirectToRoute('404');
        }
        return $next($request);
    }
}
