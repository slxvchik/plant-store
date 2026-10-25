<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::post('/callback', [UserRequestController::class, 'store'])->name('callback');

Route::prefix('user')->name('user.')->group(function () {});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::inertia('/', 'admin/Home')->name('home');

    Route::prefix('media')->name('media.')->group(function () {
        Route::prefix('image.')->group(function () {
            Route::post('/image/', [ImageController::class, 'store'])->name('create');
            Route::put('/image/{id}', [ImageController::class, 'update'])->name('update');
            Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');

        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');

        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');

        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('requests')->name('requests.')->group(function () {
        Route::get('/', [UserRequestController::class, 'index'])->name('index');
        Route::delete('/{id}', [UserRequestController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::put('/{id}', [TagController::class, 'update'])->name('update');
        Route::delete('/{id}', [TagController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('warehouses')->name('warehouses.')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('list');
        Route::post('/', [WarehouseController::class, 'store'])->name('store');
        Route::put('/{id}', [WarehouseController::class, 'update'])->name('update');
        Route::delete('/{id}', [WarehouseController::class, 'destroy'])->name('destroy');
    });
});
