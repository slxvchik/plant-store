<?php

use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::inertia('/', 'admin/Home')->name('home');
    Route::inertia('/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
});
