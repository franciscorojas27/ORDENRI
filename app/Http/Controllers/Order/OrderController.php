<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use App\Models\Resolution_Area;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public function index(HttpRequest $request)
    {   
        $query = Order::query();
        $message = ''; 
    
        switch (true) {
            case $request->filled('resolution_area'):
                $query->where('resolution_area_id', 'LIKE', "%{$request->resolution_area}%");
                $message = 'Buscando órdenes por área de resolución.';
                break;
            case $request->filled('type'):
                $query->where('type_id', 'LIKE', "%{$request->type}%");
                $message = 'Buscando órdenes por tipo.';
                break;
            case $request->filled('status'):
                $query->where('status_id', 'LIKE', "%{$request->status}%");
                $message = 'Buscando órdenes por estado.';
                break;
            default:
                $query;
                break;
        }
        $orders = $query->orderBy('id', 'asc')->paginate(10);
    
        if ($orders->count() == 0) {
            if ($request->filled('resolution_area')) {
                session()->flash('message', 'No se encontraron órdenes para el área de resolución proporcionada.');
            } elseif ($request->filled('type')) {
                session()->flash('message', 'No se encontraron órdenes del tipo proporcionado.');
            } elseif ($request->filled('status')) {
                session()->flash('message', 'No se encontraron órdenes con el estado proporcionado.');
            }
            return redirect()->route('order.index');
        }
    
        session()->flash('message', $message);
    
        return view('order.index', [
            'orders' => $orders,
            'types' => Type::all(),
            'resolution_areas' => Resolution_Area::all(),
            'statuses' => Status::all()
        ]);
    }
    public function create()
    {   
        
        return view('order.create',['types' => Type::all(), 'resolution_areas' =>  Resolution_Area::all()]);    }

    public function store(StoreOrderRequest $request)
    {
        Order::create([
            'client_id' => $request->input('user_id'),
            'resolution_area_id' => $request->input('resolution_areas'),
            'type_id' => $request->input('types'),
            'client_description' => $request->description,
            'status_id' => 1
        ]);
        return redirect()->route('order.index');
    }

    public function show(Order $order)
    {
        try {
            return view('order.show', ['RST'=> $order::getSelectOptions(),'order' => $order->getUserRelationsAttribute(), 'users' => User::getBasicUserInfo()]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('404');
        }
    }

    public function edit(Order $order)
    {
        return view('order.edit',['RST'=> $order::getSelectOptions(),'order' => $order->getUserRelationsAttribute(), 'users' => User::getBasicUserInfo()]);
    }

    public function update(UpdateOrderRequest $request, $order)
    {
        $order = Order::find($order);
        $order->update($request->updateFields());
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
    
}
