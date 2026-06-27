<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/orders', [OrderController::class, 'index'])->name('order.list');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('order.status');

    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::patch('/users/{user}/suspend', [UserController::class, 'toggleActive'])->name('user.suspend');

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
