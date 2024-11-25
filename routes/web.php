<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;

Route::middleware(['auth', 'clientVerified', 'updateUserActivity'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->get('/api/user-id', function () {
    if (request()->ajax()) {
        return response()->json(['id' => Auth::id()]);
    }
    return redirect()->route('404');
});

Route::get('/404', function () {
    return view('error.404');
})->middleware(['auth', 'verified'])->name('404');

require __DIR__ . '/auth.php';
require __DIR__ . '/orders.php';
require __DIR__ . '/metrics.php';
require __DIR__ . '/secureRoutes.php';

Route::fallback(function () {
    return redirect()->route('404');
});




