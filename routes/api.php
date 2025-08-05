<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EdupayController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// EDUPAY API - Public routes (tidak perlu authentication)
Route::post('payment-notification/{code}', [EdupayController::class, 'paymentNotification']);

Route::middleware('auth:sanctum')->group(function () {
    //Carts
    Route::get('carts', [CartController::class, 'index']);
    Route::post('carts', [CartController::class, 'store']);
    Route::put('carts/{id}', [CartController::class, 'update']);
    Route::delete('carts/{id}', [CartController::class, 'destroy']);

    // Transaction routes
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::put('transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);

    //Merchants
    Route::get('merchants', [MerchantController::class, 'index']);
    Route::post('merchants', [MerchantController::class, 'store']);
    Route::put('merchants/{id}', [MerchantController::class, 'update']);
    Route::delete('merchants/{id}', [MerchantController::class, 'destroy']);

    //Products
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    //Profile
    Route::get('profile', [UserController::class, 'profile']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::put('profile/password', [UserController::class, 'changePassword']);

    //Auth
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh-token', [UserController::class, 'refreshToken']);
});


