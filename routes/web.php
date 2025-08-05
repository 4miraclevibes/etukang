<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Landing\WelcomeController;
use App\Http\Controllers\Landing\CartController;
use App\Http\Controllers\Landing\TransactionController;
use App\Http\Controllers\Landing\ProfileController as LandingProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return redirect()->route('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/{id}', [CartController::class, 'show'])->name('cart.show');

    // Transaction Routes
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');

    // Profile Routes (Mobile)
    Route::get('/profile/mobile', [LandingProfileController::class, 'index'])->name('profile.mobile');
    Route::get('/profile/mobile/edit', [LandingProfileController::class, 'edit'])->name('profile.mobile.edit');

    // Profile Routes (Web)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Tambahkan route ini untuk testing
Route::get('/merchant/{id}/details', function($id) {
    $merchant = \App\Models\Merchant::with('products')->find($id);
    return response()->json(['merchant' => $merchant]);
});
