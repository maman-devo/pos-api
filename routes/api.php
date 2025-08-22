<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TransactionController;

// --- Rute Publik (Tidak perlu login) ---
Route::post('v1/login', [AuthController::class, 'login']);
Route::get('v1/products', [ProductController::class, 'index']);
Route::get('v1/products/{product}', [ProductController::class, 'show']);
Route::get('v1/categories', [CategoryController::class, 'index']);


// --- Rute Terproteksi (Wajib login) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('v1/logout', [AuthController::class, 'logout']);
    Route::get('v1/user', function (Request $request) {
        return $request->user();
    });

    // Contoh rute transaksi yang sekarang dilindungi
    Route::post('v1/transactions', [TransactionController::class, 'store']);
});