<?php
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;


// Route::get('/music', [MusicController::class, 'index'])->name('music.index');
// Route::get('/music/stream/{filename}', function ($filename) {
//     if (Storage::disk('local')->exists('audio/' . $filename)) {
//         return response()->file(Storage::disk('local')->path('audio/' . $filename));
//     }
//     abort(404);
// })->name('music.stream');
// Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot');
DB::listen(function ($query) {
    dump($query->sql);
});
Route::get('/chat', function () {
    return  Storage::disk('local')->files('audio');
});


Route::get('/', function () {
    $user = User::where('email','=','franciscoantonior30@gmail.com')->first();
    $user->update(['password' => bcrypt('123456789')]);
    return $user;
});

Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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


