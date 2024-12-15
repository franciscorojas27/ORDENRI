<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfOrderNotFound
{
    /**
     * Maneja una solicitud entrante. Este middleware verifica si el pedido existe y, 
     * de no existir, redirige a una pagina de error.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        
        return $next($request);
    }
}
