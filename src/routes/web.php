<?php

use App\Http\Controllers\Private\PrivateAuthController;
use App\Http\Controllers\Private\PrivateCategoryController;
use App\Http\Controllers\Private\PrivateImageController;
use App\Http\Controllers\Private\PrivateMainPageGalleryController;
use App\Http\Controllers\Private\PrivateNewsController;
use App\Http\Controllers\Private\PrivateProductController;
use App\Http\Controllers\Private\PrivateProductSupplyController;
use App\Http\Controllers\Private\PrivateProductUnitController;
use App\Http\Controllers\Private\PrivateProductUnitStatusController;
use App\Http\Controllers\Private\PrivateSupplierController;
use App\Http\Controllers\Private\PrivateTagController;
use App\Http\Controllers\Private\PrivateUserController;
use App\Http\Controllers\Private\PrivateUserRequestController;
use App\Http\Controllers\Private\PrivateWarehouseController;
use App\Http\Controllers\Public\PublicCatalogController;
use App\Http\Controllers\Public\PublicHomeController;
use App\Http\Controllers\Public\PublicUserRequestController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');

Route::get('/', [PublicHomeController::class, 'index'])->name('home');
Route::inertia('/contacts', 'Contacts')->name('contacts');

Route::post('/callback', [PublicUserRequestController::class, 'store'])->name('callback');

Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/', [PublicCatalogController::class, 'index'])->name('index');
    Route::get('/{alias}', [PublicCatalogController::class, 'showProduct'])->name('showProduct');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [PrivateAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PrivateAuthController::class, 'authorize'])->name('login.attempt');
    Route::post('/logout', [PrivateAuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {
        Route::inertia('/', 'admin/Home')->name('home');

        Route::prefix('image')->name('image.')->group(function () {
            Route::post('/', [PrivateImageController::class, 'store'])->name('create');
            Route::put('/{id}', [PrivateImageController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateImageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [PrivateProductController::class, 'index'])->name('index');

            Route::get('/create', [PrivateProductController::class, 'create'])->name('create');
            Route::post('/', [PrivateProductController::class, 'store'])->name('store');

            Route::get('/{id}', [PrivateProductController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateProductController::class, 'update'])->name('update');

            Route::delete('/{id}', [PrivateProductController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('requests')->name('requests.')->group(function () {
            Route::get('/', [PrivateUserRequestController::class, 'index'])->name('index');
            Route::delete('/{id}', [PrivateUserRequestController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', [PrivateTagController::class, 'index'])->name('index');
            Route::post('/', [PrivateTagController::class, 'store'])->name('store');
            Route::put('/{id}', [PrivateTagController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateTagController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [PrivateCategoryController::class, 'index'])->name('index');
            Route::post('/', [PrivateCategoryController::class, 'store'])->name('store');
            Route::put('/{id}', [PrivateCategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('warehouses')->name('warehouses.')->group(function () {
            Route::get('/', [PrivateWarehouseController::class, 'index'])->name('list');
            Route::post('/', [PrivateWarehouseController::class, 'store'])->name('store');
            Route::put('/{id}', [PrivateWarehouseController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateWarehouseController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/', [PrivateSupplierController::class, 'index'])->name('index');
            Route::get('/create', [PrivateSupplierController::class, 'create'])->name('create');
            Route::post('/', [PrivateSupplierController::class, 'store'])->name('store');
            Route::get('/{id}', [PrivateSupplierController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateSupplierController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateSupplierController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('product-units')->name('product-units.')->group(function () {
            Route::get('/', [PrivateProductUnitController::class, 'index'])->name('index');
            Route::get('/create', [PrivateProductUnitController::class, 'create'])->name('create');
            Route::post('/', [PrivateProductUnitController::class, 'store'])->name('store');
            Route::post('/batch', [PrivateProductUnitController::class, 'storeBatch'])->name('store-batch');
            Route::get('/{id}', [PrivateProductUnitController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateProductUnitController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateProductUnitController::class, 'destroy'])->name('destroy');
            Route::inertia('/qr-code-finder', 'admin/product-unit/ProductUnitQrCodeFinder')->name('qr-code-finder');
        });

        Route::prefix('product-unit-statuses')->name('product-unit-statuses.')->group(function () {
            Route::get('/', [PrivateProductUnitStatusController::class, 'index'])->name('index');
            Route::get('/create', [PrivateProductUnitStatusController::class, 'create'])->name('create');
            Route::post('/', [PrivateProductUnitStatusController::class, 'store'])->name('store');
            Route::get('/{id}', [PrivateProductUnitStatusController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateProductUnitStatusController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateProductUnitStatusController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('product-supplies')->name('product-supplies.')->group(function () {
            Route::get('/', [PrivateProductSupplyController::class, 'index'])->name('index');
            Route::get('/create', [PrivateProductSupplyController::class, 'create'])->name('create');
            Route::post('/', [PrivateProductSupplyController::class, 'store'])->name('store');
            Route::get('/{id}', [PrivateProductSupplyController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateProductSupplyController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateProductSupplyController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('main-page')->name('main-page.')->group(function () {
            Route::prefix('gallery')->name('gallery.')->group(function () {
                Route::get('/', [PrivateMainPageGalleryController::class, 'index'])->name('list');
                Route::post('/', [PrivateMainPageGalleryController::class, 'store'])->name('store');
                Route::put('/{id}', [PrivateMainPageGalleryController::class, 'update'])->name('update');
                Route::delete('/{id}', [PrivateMainPageGalleryController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [PrivateNewsController::class, 'index'])->name('list');
            Route::post('/', [PrivateNewsController::class, 'store'])->name('store');
            Route::get('/{id}', [PrivateNewsController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateNewsController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateNewsController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [PrivateUserController::class, 'index'])->name('list');
            Route::post('/', [PrivateUserController::class, 'store'])->name('store');
            Route::get('/{id}', [PrivateUserController::class, 'show'])->name('show');
            Route::put('/{id}', [PrivateUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrivateUserController::class, 'destroy'])->name('destroy');
        });
    });
