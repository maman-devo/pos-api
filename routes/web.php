<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // === TAMBAHKAN KODE DI BAWAH INI ===
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'App\Http\Controllers\Admin',
    ], function () {
        // Route untuk Produk
        Route::resource('products', ProductController::class);
        // Route untuk Kategori
        Route::resource('categories', CategoryController::class);
        // Route untuk Pengguna (Users) 
        Route::resource('users', UserController::class);
        Route::resource('promos', PromoController::class);
        Route::resource('payment-methods', PaymentMethodController::class);

        // Route untuk toggle status promo
        Route::post('promos/{promo}/toggle-status', [PromoController::class, 'toggleStatus'])->name('promos.toggleStatus');

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::post('stocks/{product}', [StockController::class, 'update'])->name('stocks.update');
        Route::get('stocks/history', [StockController::class, 'history'])->name('stocks.history');
    });
    // ===================================

});

require __DIR__ . '/auth.php';