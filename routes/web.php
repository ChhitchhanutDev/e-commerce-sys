<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/categories', [CategoryController::class, 'index'])->name('cate.list');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('cate.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('cate.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('cate.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('cate.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('cate.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('product.list');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});
