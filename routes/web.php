<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Payments\MpesaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/mpesa', fn () => Inertia::render('AccessToken'));
Route::get('/api/access-token', [MpesaController::class, 'getAccessToken'])->name('mpesa.getAccessToken');
Route::get('/api/register-urls', [MpesaController::class, 'registerUrls'])->name('mpesa.registerUrls');
Route::get('/api/simulate-payment', [MpesaController::class, 'simulatePayment'])->name('mpesa.simulatePayment');

Route::get('/stk', function () {
    return Inertia::render('StkPush');
});
Route::post('/stk-push', [MpesaController::class, 'stkPush'])->name('mpesa.stkPush');

Route::get('/test-env', function () {
    return response()->json([
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
    ]);
});





require __DIR__.'/auth.php';
