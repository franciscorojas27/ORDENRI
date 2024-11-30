<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Resolution_Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class orderGroupController extends Controller
{
    /**
     * Muestra una lista de órdenes filtradas según el rol del usuario.
     * Si el usuario pertenece a un grupo, se filtran las órdenes por su área de coordinación.
     * Si no pertenece a un grupo, se filtran por su propio ID de usuario.
     *
     * @param Request $request La solicitud HTTP que contiene los filtros de búsqueda.
     * @return \Illuminate\View\View La vista que muestra las órdenes filtradas.
     */
    public function index(Request $request)
    {
        // Definir la función de redirección en un solo lugar
        $getRedirectRouteToShow = function ($order) {
            if (request()->routeIs('order.group.index') || request()->routeIs('order.group.show')) {
                return route('order.group.show', $order);
            }

            return request()->routeIs('order.consultation.index') ? route('order.consultation.show', $order) : route('order.show', $order);
        };

        // Crear la consulta base
        $query = Order::with('applicantTo', 'type', 'resolutionArea', 'status')
            ->where('status_id', 2); // Filtrar por estado de la orden

        // Aplicar filtro adicional si el usuario pertenece a un grupo
        if (Auth::user()->group) {
            $query->whereHas('applicantTo', function ($query) {
                $query->where('coordination_management', Auth::user()->coordination_management);
            });
        } else {
            // Si el usuario no pertenece a un grupo, filtrar por su propio ID
            $query->where('applicant_to_id', Auth::id());
        }

        // Realizar la consulta y paginar los resultados
        $orders = $query->orderBy('id', 'asc')->paginate(10);

        // Retornar la vista con los datos
        return view('order.index', [
            'orders' => $orders,
            'types' => Type::all(),
            'resolution_areas' => Resolution_Area::all(),
            'statuses' => Status::all(),
            'getRedirectRoute' => function ($order) {
                return OrderController::getRedirectRouteToShow($order);
            }
        ]);
    }

}
