<?php

use App\Http\Controllers\PaymentController;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

    Route::prefix('payment')->group(function() {
        Route::get('/create-boleto', [PaymentController::class, 'createBoleto'])->name('payment.create-boleto');
        Route::get('/create-pix', [PaymentController::class, 'createPix'])->name('payment.create-pix');
        Route::get('/create-credit-card', [PaymentController::class, 'createCreditCard'])->name('payment.create-credit-card');
        Route::post('/validate', [PaymentController::class, 'validatePayment'])->name('payment.validate');
        Route::post('/validate-credit-card', [PaymentController::class, 'validatePaymentCreditCard'])->name('payment.validate-credit-card');
        Route::post('/process', [PaymentController::class, 'process'])->name('payment.process');
    });
});

require __DIR__.'/auth.php';
