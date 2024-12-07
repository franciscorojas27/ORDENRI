<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::middleware(['auth', 'verified', 'updateUserActivity'])->group(function () {
    Route::get('/orders/{order}/files/{file}/download', [FileController::class, 'download'])->name('order.file.download');
    Route::delete('orders/{order}/files/{file}', [FileController::class, 'deleteFile'])->name('order.files.delete');
});