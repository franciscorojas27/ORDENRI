<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NonConformityRecords;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\orderGroupController;

Route::middleware(['auth', 'verified', 'updateUserActivity'])->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->where('order', '[0-9]+')->name('order.show');
    Route::get('orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('orders/create', [OrderController::class, 'store'])->name('order.store');

    Route::middleware('clientVerified')->group(function () {
        Route::put('orders/{order}', [OrderController::class, 'orderFlow'])->name('order.flow');
        Route::middleware('blockAnalyzer')->group(function () {
            Route::post('orders/{order}/non-conformity', [NonConformityRecords::class, 'store'])->name('order.non-conformity');
            Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
            Route::put('orders/{order}/edit', [OrderController::class, 'update'])->name('order.update');
            Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        });
        Route::get('group/orders/', [orderGroupController::class, 'index'])->name('order.group.index');
        Route::get('group/orders/{order}', [OrderController::class, 'show'])->name('order.group.show');
    });
});


require __DIR__ . '/files.php';
require __DIR__ . '/orderConsultation.php';
