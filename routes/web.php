<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Landing\WelcomeController;
use App\Http\Controllers\Landing\CartController;
use App\Http\Controllers\Landing\TransactionController;
use App\Http\Controllers\Landing\ProfileController as LandingProfileController;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\ProfileController as MerchantProfileController;
use App\Http\Controllers\Merchant\ProductController;
use App\Http\Controllers\Merchant\TransactionController as MerchantTransactionController;
use App\Http\Controllers\Merchant\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Middleware untuk mengecek apakah user adalah merchant
Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect dashboard berdasarkan tipe user
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Jika user memiliki merchant profile, arahkan ke dashboard merchant
        if ($user && $user->merchant) {
            return redirect()->route('merchant.dashboard');
        }

        // Jika tidak, arahkan ke welcome page (untuk customer)
        return redirect()->route('welcome');
    })->name('dashboard');

    // Customer Routes (hanya untuk user yang bukan merchant)
    Route::middleware('customer')->group(function () {
        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::get('/cart/{id}', [CartController::class, 'show'])->name('cart.show');

        // Transaction Routes
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');

        // Profile Routes (Mobile)
        Route::get('/profile/mobile', [LandingProfileController::class, 'index'])->name('profile.mobile');
        Route::get('/profile/mobile/edit', [LandingProfileController::class, 'edit'])->name('profile.mobile.edit');
    });

    // Profile Routes (Web) - untuk semua user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Merchant Routes (hanya untuk user yang memiliki merchant profile)
Route::prefix('merchant')->name('merchant.')->middleware(['auth', 'verified', 'merchant'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-status', [DashboardController::class, 'updateStatus'])->name('dashboard.update-status');

    // Profile
    Route::get('/profile', [MerchantProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [MerchantProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/update', [MerchantProfileController::class, 'update'])->name('profile.update');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{product}/status', [ProductController::class, 'updateStatus'])->name('products.update-status');

    // Transactions
    Route::get('/transactions', [MerchantTransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/{transaction}', [MerchantTransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/status', [MerchantTransactionController::class, 'updateStatus'])->name('transactions.update-status');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');
});

require __DIR__.'/auth.php';

// Tambahkan route ini untuk testing
Route::get('/merchant/{id}/details', function($id) {
    $merchant = \App\Models\Merchant::with('products')->find($id);
    return response()->json(['merchant' => $merchant]);
});
