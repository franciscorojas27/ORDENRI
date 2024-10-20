<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;

class Handler extends ExceptionsHandler
{
    public function register()
    {
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'message' => 'Demasiadas solicitudes. Tienes permitido 5 intentos por día.'
            ], 429);
        });
    }
}
