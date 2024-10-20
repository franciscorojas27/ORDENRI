<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\User;
use App\Models\Order;
use App\Models\Resolution_Area;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public function index()
    {   
        $orders = Order::orderBy('created_at', 
        'desc')->paginate(10);
        return view('order.index')->with('orders', $orders);
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
        $order->save();
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
