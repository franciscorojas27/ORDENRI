<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\NonConformityRecord;
use Illuminate\Support\Facades\Auth;

class NonConformityRecords extends Controller
{
    public function store(Order $order)
    {
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
        return redirect()->route('order.edit',$order);
    }
}
