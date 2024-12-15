<?php

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/api/metrics', function (Request $request) {
    if (!$request->ajax()) {
        return redirect('404');
    }
    $month = (int) $request->query('month');
    $year = (int) $request->query('year');
    $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    $ordersFirst7Days = [0, 0, 0, 0, 0, 0, 0];
    $ordersFirst15Days = [0, 0, 0, 0, 0, 0, 0];
    $ordersFirst30Days = [0, 0, 0, 0, 0, 0, 0];

    $orders30Days = Order::where('created_at', '>=', $startOfMonth)
        ->where('created_at', '<', $startOfMonth->copy()->addDays(30))
        ->get();
    foreach ($orders30Days as $order) {
        $day = $order->created_at->dayOfWeek;

        if ($day == 0) {
            $day = 6;
        } else {
            $day--;
        }
        if ($order->created_at->day <= 7) {
            $ordersFirst7Days[$day]++;
        }
        if ($order->created_at->day <= 15) {
            $ordersFirst15Days[$day]++;
        }
        if ($order->created_at->day <= 30) {
            $ordersFirst30Days[$day]++;
        }
    }
    return response()->json([
        30 => $ordersFirst30Days,
        15 => $ordersFirst15Days,
        7 => $ordersFirst7Days,
    ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
})->name('api.metrics');
