<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/api/metrics', function (Request $request) {
    if (!$request->ajax()) {
        return redirect('404');
    }
    $chartData = [
        30 => [12, 19, 3, 5, 2, 3, 10],
        15 => [5, 3, 4, 8, 7, 9, 6],
        7 => [2, 5, 1, 3, 4, 6, 8],
    ];
    return response()->json([$chartData]);
})->name('api.metrics');
