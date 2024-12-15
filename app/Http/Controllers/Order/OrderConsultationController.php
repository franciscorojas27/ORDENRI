<?php

namespace App\Http\Controllers\Order;


use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class OrderConsultationController extends Controller
{
    /**
     * Método index
     * 
     * Maneja la lógica para consultar y filtrar órdenes en base a parámetros de entrada.
     * 
     * @param \Illuminate\Http\Request $request - La solicitud HTTP con posibles parámetros:
     *   - month: (requerido) Mes de la orden (1-12).
     *   - year: (requerido) Año de la orden (2015-actual).
     *   - applicant_to: (opcional) ID del usuario solicitante.
     *   - responsible_to: (opcional) ID del usuario responsable.
     * 
     * @return \Illuminate\View\View - Devuelve la vista 'order-consultation.index' con los datos filtrados.
     */
    public function index(Request $request)
    {
        $supervisor = User::whereHas('jobTitle', fn($query) => $query->whereIn('title', ['Supervisor']))->get();
        $responsible = User::whereHas('jobTitle', fn($query) => $query->whereIn('title', ['Analista', 'Supervisor']))->get();

        // Verificar si se proporcionaron 'month' y 'year' para aplicar filtros.
        if ($request->filled('month') && $request->filled('year')) {
            // Validación de los parámetros del request.
            $request->validate([
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|digits:4|between:2012,' . date('Y'),
                'applicant_to' => 'nullable|integer|exists:users,id',
                'responsible_to' => 'nullable|integer|exists:users,id',
            ]);
            $orders = Order::query()
                ->whereYear('created_at', $request->year) 
                ->whereMonth('created_at', $request->month) 
                ->when($request->applicant_to, fn($query) => $query->where('applicant_to_id', $request->applicant_to)) 
                ->when($request->responsible_to, fn($query) => $query->where('responsible_id', $request->responsible_to)) 
                ->orderBy('created_at', 'asc') 
                ->get();

            session()->flash('message', "Se encontraron {$orders->count()} ordenes para el mes {$request->month} del año {$request->year}.");

            $getRedirectRoute = fn($order) => route(
                request()->routeIs('order.group.index') || request()->routeIs('order.group.show')
                ? 'order.group.show'
                : 'order.consultation.show',
                $order
            );

            return view('order-consultation.index', compact('orders', 'getRedirectRoute', 'supervisor', 'responsible'));
        }

        return view('order-consultation.index', compact('supervisor', 'responsible'));
    }
    /**
     * Muestra los detalles de una orden específica en la vista.
     *
     * @param  \App\Models\Order  $order  La orden de servicio que se desea visualizar.
     * @return \Illuminate\View\View  La vista 'order-consultation.show' con la información de la orden.
     */
    public function show(Order $order)
    {
        return view('order-consultation.show', compact('order'));
    }

    /**
     * Genera y descarga un archivo PDF para una orden específica.
     *
     * @param  \App\Models\Order  $order  La orden de servicio para la cual se generará el PDF.
     * @return \Illuminate\Http\Response  El archivo PDF descargable.
     */
    public function download(Order $order)
    {
        $pdf = Pdf::loadView('pdf.order-consultation', compact('order'));
        return $pdf->download("Orden de Servicio n° {$order->id}.pdf");
    }

}
