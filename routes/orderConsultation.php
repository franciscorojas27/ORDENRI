<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\OrderConsultationController;

Route::middleware(['auth', 'verified', 'updateUserActivity'])->group(function () {
    Route::get('orders/consultation/index', [OrderConsultationController::class, 'index'])->name('order.consultation.index');

    Route::get('orders/consultation/{order}', [OrderConsultationController::class, 'show'])->name('order.consultation.show');

    Route::get('orders/consultation/{order}/download', [OrderConsultationController::class, 'download'])->name('order.consultation.download');
});