<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use SaKanjo\EasyMetrics\Metrics\Value;

class DashBoardController extends Controller
{
    public function index(Request $request)
    {   
        $counts = [];
        $statusNames = Status::pluck('status')->toArray();
        foreach ($statusNames as $key => $statusName) {
            $counts[$statusName] = Order::where('status_id', $key + 1)->count();
        }
        return view('dashboard', ['counts' => $counts]);
    }
    
}
