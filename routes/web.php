<?php
use App\Mail\WelcomeToTheJungle;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;


Route::get('/', function () {
    $cacheKeys = Cache::getKeys(); // Solo si tienes un paquete que soporte esto
    $cacheContents = [];

    foreach ($cacheKeys as $key) {
        $cacheContents[$key] = Cache::get($key);
    }

    return response()->json($cacheContents);
});
Route::get('/email', function () {
    // return Order::find(1)->getUserRelationsAttribute();
    Mail::to('arojas@cantv.com.ve')->send(new WelcomeToTheJungle());  
    }); 

Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified','clientVerified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/404', function () {
    return view('error.404');
})->middleware(['auth', 'verified'])->name('404');

require __DIR__.'/auth.php';
require __DIR__.'/orders.php';
require __DIR__.'/metrics.php';
require __DIR__.'/secureRoutes.php';

Route::fallback(function () {
    return redirect()->route('404');
});


// $users = User::whereMonth('email_verified_at', 10)
//     ->whereYear('email_verified_at', 2024)
//     ->whereRaw('WEEKDAY(email_verified_at) < 5')
//     ->get();


