<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\NonConformityRecord;
use Illuminate\Support\Facades\Auth;

class NonConformityRecords extends Controller
{
    /**
     * Almacena un registro de no conformidad y actualiza el estado de la orden.
     *
     * Luego de almacenar el registro de no conformidad, se actualiza el estado de la orden
     * a En curso y se establece la fecha de inicio y finalización.
     * Finalmente se redirige al usuario a la vista de edición de la orden.
     *
     * @param  \App\Models\Order  $order La orden que se va a actualizar.
     * @return \Illuminate\Http\Response La respuesta HTTP con la redirección a la vista de edición de la orden.
     */
    public function store(Order $order)
    {
        if ($order->status_id === 3) {
            NonConformityRecord::create(
                [
                    'order_id' => $order->id,
                    'start_at' => $order->start_at,
                    'end_at' => $order->end_at,
                    'client_description' => $order->client_description,
                    'description' => $order->description,
                    'non_conformity_done_by_user_id' => Auth::id(),
                ]
            );
            $order->update(
                [
                    'status_id' => 2,
                    'start_at' => now(),
                    'end_at' => null,
                ]
            );
            return redirect()->route('order.edit', $order);
        }
        return redirect()->route('order.edit', $order)->withError(['error' => 'Ha ocurrido un error al procesar la solicitud.']);

    }
}
