<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'loginProcess']);
Route::post('/register', [AuthController::class, 'registerProcess']);

Route::get('/', [ProductController::class, 'katalog'])->name('katalog');

Route::middleware(['auth'])->group(function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // keranjang belanja
    Route::post('/keranjang/tambah/{id}', [TransactionController::class, 'tambahKeKeranjang']);
    Route::get('/keranjang', [TransactionController::class, 'lihatKeranjang'])->name('keranjang');
    Route::post('/keranjang/update/{id}', [TransactionController::class, 'updateKeranjang']);
    Route::post('/keranjang/hapus/{id}', [TransactionController::class, 'hapusDariKeranjang']);

    // checkout / bikin faktur
    Route::post('/checkout', [TransactionController::class, 'checkout']);
});

Route::middleware(['tolak.user'])->group(function () {
    Route::get('/admin/dashboard', [ProductController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/tambah', [ProductController::class, 'create']);
    Route::post('/admin/tambah', [ProductController::class, 'store']);
    Route::post('/admin/hapus/{id}', [ProductController::class, 'destroy']);
    Route::get('/admin/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/admin/edit/{id}', [ProductController::class, 'update']);
});
