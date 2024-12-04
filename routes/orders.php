<?php

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\NonConformityRecords;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\orderGroupController;
use App\Http\Controllers\Order\OrderConsultationController;

Route::middleware(['auth', 'verified', 'updateUserActivity'])->group(function () {
    Route::get('orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('orders/create', [OrderController::class, 'store'])->name('order.store');
    Route::get('orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('order.show');

    // Rutas que manejan la descarga y eliminación de archivos asociados a la orden (Se requiere estar auth y verified para acceder)
    Route::get('/orders/{order}/files/{file}/download', [FileController::class, 'download'])->name('order.file.download');
    Route::delete('orders/{order}/files/{file}', [FileController::class, 'deleteFile'])->name('order.files.delete');


    Route::middleware('clientVerified')->group(function () {
        // ruta donde se maneja el estado de la orden
        Route::put('orders/{order}', [OrderController::class, 'orderFlow'])->name('order.flow');
        Route::middleware('blockAnalyzer')->group(function () {
            Route::post('orders/{order}/non-conformity', [NonConformityRecords::class,'store'])->name('order.non-conformity');
            Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
            Route::put('orders/{order}/edit', [OrderController::class, 'update'])->name('order.update');
            Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        });
        Route::get('group/orders/', [orderGroupController::class, 'index'])->name('order.group.index');
        Route::get('group/orders/{order}', [OrderController::class, 'show'])->name('order.group.show');
    });

    // Rutas que manejan la consulta de las ordenes en el order consultation
    Route::get('orders/consultation/index', [OrderConsultationController::class, 'index'])->name('order.consultation.index');

    Route::get('orders/consultation/{order}', [OrderConsultationController::class, 'show'])->name('order.consultation.show');

    Route::get('orders/consultation/{order}/download', [OrderConsultationController::class, 'download'])->name('order.consultation.download');
});
