<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Order\OrderController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('orders/create', [OrderController::class, 'store'])->name('order.store');
    Route::middleware(['clientVerified'])->group(function () {
        Route::get('orders/index', [OrderController::class, 'index'])->name('order.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('orders/{order}/edit', [OrderController::class, 'update'])->name('order.update');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    });
});