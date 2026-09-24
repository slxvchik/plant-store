<?php

namespace App\Providers;

use App\Application\Warehouse\CreateWarehouse\CreateWarehouseService;
use App\Application\Warehouse\CreateWarehouse\CreateWarehouseUseCase;
use App\Application\Warehouse\DeleteWarehouse\DeleteWarehouseService;
use App\Application\Warehouse\DeleteWarehouse\DeleteWarehouseUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesService;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseService;
use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseUseCase;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use App\Generators\UuidGenerator;
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

        $this->app->singleton(
            GetAllWarehousesUseCase::class,
            GetAllWarehousesService::class
        );

        $this->app->singleton(
            CreateWarehouseUseCase::class,
            CreateWarehouseService::class
        );

        $this->app->singleton(
            UpdateWarehouseUseCase::class,
            UpdateWarehouseService::class
        );

        $this->app->singleton(
            DeleteWarehouseUseCase::class,
            DeleteWarehouseService::class
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
