<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionsHandler;

class Handler extends ExceptionsHandler
{
    /**
     * Registra los manejadores de excepciones personalizadas para la aplicación.
     *
     * En este caso, maneja la excepción ThrottleRequestsException y devuelve una
     * respuesta JSON con un mensaje de error y un código de estado HTTP 429.
     */
    public function register()
    {
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'message' => 'Demasiadas solicitudes. Tienes permitido 5 intentos por día.'
            ], 429);
        });
    }
}
