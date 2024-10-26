<?php

use App\Models\User;
use App\Mail\WelcomeToTheJungle;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminSecureUsersController;

// password.confirm
Route::middleware(['auth', 'verified', 'adminUserVerification','password.confirm'])->group(function () {
    Route::prefix('/admin-secure/users')->name('admin-secure.')->group(function () {
        Route::get('/', [AdminSecureUsersController::class, 'index'])->name('index');  // Lista de usuarios
        Route::get('/create', [AdminSecureUsersController::class, 'create'])->name('create');  // Formulario para crear usuario
        Route::post('/', [AdminSecureUsersController::class, 'store'])->name('store');  // Almacenar nuevo usuario
        Route::get('/{id}/edit', [AdminSecureUsersController::class, 'edit'])->name('edit');  // Formulario para editar usuario
        Route::put('/{user}', [AdminSecureUsersController::class, 'update'])->name('update');  // Actualizar usuario
        Route::delete('/{user}', [AdminSecureUsersController::class, 'destroy'])->name('delete');  // Eliminar usuario
        Route::patch('/{user}/reset', [AdminSecureUsersController::class, 'resetPassword'])->name('reset');  
    });
});


// Route::get('/email-prueba', function () {
//     Mail::to('arojas@cantv.com.ve')->send(new WelcomeToTheJungle());
//     return view('emails.lockout');
// });

