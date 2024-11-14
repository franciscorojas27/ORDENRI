<?php
use App\Models\User;
use App\Models\Order;
use App\Mail\OrderStartEndMail;
use App\Mail\WelcomeToTheJungle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;

// Route::get('/chat', function () {
//     $order = Order::with(['client', 'applicantTo', 'responsible'])->findOrFail(1);

//     $emails = collect([
//         $order->client->email,
//         $order->applicantTo->email,
//         $order->responsible->email
//     ])->concat(
//             User::where('resolution_area_id', $order->resolution_area_id)->pluck('email')
//         );

//     Mail::to($emails)->queue(new OrderStartEndMail($order));

// });

Route::middleware(['auth', 'clientVerified'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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


// $users = User::whereMonth('email_verified_at', 10)
//     ->whereYear('email_verified_at', 2024)
//     ->whereRaw('WEEKDAY(email_verified_at) < 5')
//     ->get();


