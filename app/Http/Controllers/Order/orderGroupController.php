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
    public function index(Request $request)
    {
        $getRedirectRouteToShow = function ($order) {
            if (request()->routeIs('order.group.index') || request()->routeIs('order.group.show')) {
                return route('order.group.show', $order);
            }

            return request()->routeIs('order.consultation.index') ? route('order.consultation.show', $order) : route('order.show', $order);
        };
        $query = Order::query()->with('applicantTo','type','resolutionArea','status');

        // Comprobar si el usuario pertenece a un grupo
        if (Auth::user()->group) {
            // Si el usuario pertenece a un grupo, filtrar por coordination_management
            $orders = $query // Carga anticipada
                ->where('status_id', 2)
                ->whereIn('applicant_to_id', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('users')
                        ->where('coordination_management', Auth::user()->coordination_management);
                })
                ->orderBy('id', 'asc')
                ->paginate(10);
        } else {
            // Si el usuario NO pertenece a un grupo, solo filtrar por su ID
            $orders = $query // Carga anticipada
                ->where('status_id', 2)
                ->where('applicant_to_id', Auth::id())
                ->orderBy('id', 'asc')
                ->paginate(10);
        }

        return view('order.index', [
            'orders' => $orders,
            'types' => Type::all(),
            'resolution_areas' => Resolution_Area::all(),
            'statuses' => Status::all(),
            'getRedirectRoute' => $getRedirectRouteToShow
        ]);
    }
}
