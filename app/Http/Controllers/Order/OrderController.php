<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Mail\OrderStartEndMail;
use App\Models\Resolution_Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->jobTitle->title === 'Cliente') {

            $ordersIds = Order::where('client_id', Auth::user()->id)->pluck('id');

            $query = Order::with('applicantTo', 'type', 'resolutionArea', 'status')
                ->whereIn('id', $ordersIds)
                ->orderBy('id', 'asc');

            return view('order.index', [
                'orders' => $query->paginate(10),
                'types' => Type::all(),
                'resolution_areas' => Resolution_Area::all(),
                'statuses' => Status::all(),
                'getRedirectRoute' => function ($order) {
                    return $this->getRedirectRouteToShow($order);
                }
            ]);
        }

        $query = Order::query()->with('applicantTo', 'type', 'resolutionArea', 'status');

        $message = $this->applyFilters($request, $query);

        $orders = $query->orderBy('id', 'desc')->paginate(30);

        if ($orders->isEmpty()) {
            $errorMessage = $this->getEmptyOrdersMessage($request);
            session()->flash('message', $errorMessage);

            return redirect()->route(request()->route()->getName());
        }

        session()->flash('message', $message);

        return view('order.index', [
            'orders' => $orders,
            'types' => Type::all(),
            'resolution_areas' => Resolution_Area::all(),
            'statuses' => Status::all(),
            'getRedirectRoute' => function ($order) {
                return $this->getRedirectRouteToShow($order);
            }
        ]);
    }


    public function create()
    {

        return view('order.create', ['types' => Type::all(), 'resolution_areas' => Resolution_Area::all()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'client_id' => $request->input('user_id'),
            'resolution_area_id' => $request->input('resolution_areas'),
            'type_id' => $request->input('types'),
            'client_description' => $request->description,
            'status_id' => 1
        ]);
        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));
        return redirect()->route('order.index');
    }

    public function show(Order $order)
    {
        $redirectRoute = $this->getRedirectRouteToIndex();

        return view('order.show', compact('order', 'redirectRoute'));
    }

    public function edit(Order $order)
    {
        return view('order.edit', ['RST' => $order::getSelectOptions(), 'order' => $order->getUserRelationsAttribute(), 'users' => User::getBasicUserInfo()]);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->updateFields());
        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));
        return redirect()->route('order.index');
    }
    /**
     * Elimina una orden especifica de la base de datos.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('order.index');
    }

    public function orderFlow(Order $order, Request $request)
    {
        $request->validate([
            'description' => 'required|min:10|max:500',
        ]);
        $updateData = ['description' => $request->description];

        switch ($order->status_id) {
            case 1:
                $updateData['status_id'] = 2;
                $updateData['start_at'] = now();
                $updateData['applicant_to_id'] = Auth::id();
                break;
            case 2:
                $updateData['status_id'] = 3;
                $updateData['end_at'] = now();
                break;
        }
        $order->update($updateData);
        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));

        return redirect()->route('order.index');
    }
    public function getRedirectRouteToIndex()
    {
        if (request()->routeIs('order.consultation.show')) {
            return route('order.consultation.index');
        } elseif (request()->routeIs('order.show')) {
            return route('order.index');
        } elseif (request()->routeIs('order.group.show')) {
            return route('order.group.index');
        }

        return route('order.index');
    }
    // Método estático para aplicar los filtros
    public static function applyFilters(Request $request, $query)
    {
        return match (true) {
            $request->filled('resolution_area') => tap('Buscando órdenes por área de resolución.', fn() =>
                $query->where('resolution_area_id', 'LIKE', "%{$request->resolution_area}%")),
            $request->filled('type') => tap('Buscando órdenes por tipo.', fn() =>
                $query->where('type_id', 'LIKE', "%{$request->type}%")),
            $request->filled('status') => tap('Buscando órdenes por estado.', fn() =>
                $query->where('status_id', 'LIKE', "%{$request->status}%")),
            default => 'Mostrando todas las órdenes.'
        };
    }

    // Método para obtener mensaje cuando no hay órdenes
    public static function getEmptyOrdersMessage(Request $request)
    {
        return match (true) {
            $request->filled('resolution_area') => 'No se encontraron órdenes para el área de resolución proporcionada.',
            $request->filled('type') => 'No se encontraron órdenes del tipo proporcionado.',
            $request->filled('status') => 'No se encontraron órdenes con el estado proporcionado.',
            default => 'No se encontraron órdenes.'
        };
    }
    public static function getRedirectRouteToShow(?Order $order = null)
    {
        if (request()->routeIs('order.group.index') || request()->routeIs('order.group.show')) {
            return route('order.group.show', $order);
        }

        return request()->routeIs('order.consultation.index') ? route('order.consultation.show', $order) : route('order.show', $order);
    }
}



