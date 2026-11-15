<?php

use App\Http\Controllers\AdminImageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainPageGalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSupplyController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\ProductUnitStatusController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');

Route::inertia('/', 'Home')->name('home');
Route::inertia('/contacts', 'Contacts')->name('contacts');

Route::post('/callback', [UserRequestController::class, 'store'])->name('callback');

Route::prefix('catalog')->name('catalog.')->group(function () {
//    Route::get('/', )
    Route::inertia('/', 'catalog/CatalogIndex')->name('catalog');
    Route::inertia('/{alias}', 'catalog/ProductDetail')->name('catalog.product');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [UserCartController::class, 'index'])->name('list');
        Route::post('/products', [UserCartController::class, 'store'])->name('store');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::inertia('/', 'admin/Home')->name('home');

    Route::prefix('image')->name('image.')->group(function () {
        Route::post('/', [AdminImageController::class, 'store'])->name('create');
        Route::put('/{id}', [AdminImageController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminImageController::class, 'destroy'])->name('destroy');
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

    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
        Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('product-units')->name('product-units.')->group(function () {
        Route::get('/', [ProductUnitController::class, 'index'])->name('index');
        Route::get('/create', [ProductUnitController::class, 'create'])->name('create');
        Route::post('/', [ProductUnitController::class, 'store'])->name('store');
        Route::post('/batch', [ProductUnitController::class, 'storeBatch'])->name('store-batch');
        Route::get('/{id}', [ProductUnitController::class, 'show'])->name('show');
        Route::put('/{id}', [ProductUnitController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductUnitController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('product-unit-statuses')->name('product-unit-statuses.')->group(function () {
        Route::get('/', [ProductUnitStatusController::class, 'index'])->name('index');
        Route::get('/create', [ProductUnitStatusController::class, 'create'])->name('create');
        Route::post('/', [ProductUnitStatusController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductUnitStatusController::class, 'show'])->name('show');
        Route::put('/{id}', [ProductUnitStatusController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductUnitStatusController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('product-supplies')->name('product-supplies.')->group(function () {
        Route::get('/', [ProductSupplyController::class, 'index'])->name('index');
        Route::get('/create', [ProductSupplyController::class, 'create'])->name('create');
        Route::post('/', [ProductSupplyController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductSupplyController::class, 'show'])->name('show');
        Route::put('/{id}', [ProductSupplyController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductSupplyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('main-page')->name('main-page.')->group(function () {
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', [MainPageGalleryController::class, 'index'])->name('list');
            Route::post('/', [MainPageGalleryController::class, 'store'])->name('store');
            Route::put('/{id}', [MainPageGalleryController::class, 'update'])->name('update');
            Route::delete('/{id}', [MainPageGalleryController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('list');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::get('/{id}', [NewsController::class, 'show'])->name('show');
        Route::put('/{id}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{id}', [NewsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});
