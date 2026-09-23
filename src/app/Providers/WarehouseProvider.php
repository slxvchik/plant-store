<?php

namespace App\Providers;

use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesService;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use App\Repositories\WarehouseRepositoryImpl;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class WarehouseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            WarehouseRepository::class,
            WarehouseRepositoryImpl::class
        );

        $this->app->bind(
            GetAllWarehousesUseCase::class,
            GetAllWarehousesService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
