<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockAnalyzer
{
    /**
     * Maneja una solicitud entrante para denegar el acceso a los usuarios con rol de analista.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->user()->isAnalyzer()) {
            return $next($request);
        }
        return redirect()->route('order.index');
    }
}
