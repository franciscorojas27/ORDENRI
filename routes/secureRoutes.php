<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSecureUsersController;

Route::middleware(['auth', 'verified', 'userValidated', 'adminUserVerification', 'password.confirm', 'updateUserActivity'])->group(function () {
    Route::prefix('/admin-secure/users')->name('admin-secure.')->group(function () {
        Route::get('/', [AdminSecureUsersController::class, 'index'])->name('index');
        Route::get('/create', [AdminSecureUsersController::class, 'create'])->name('create');
        Route::post('/', [AdminSecureUsersController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdminSecureUsersController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminSecureUsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminSecureUsersController::class, 'destroy'])->name('delete');
        Route::patch('/{user}/reset', [AdminSecureUsersController::class, 'resetPassword'])->name('reset');
    });
});

