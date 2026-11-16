<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsService;
use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsUseCase;
use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitService;
use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitUseCase;
use App\Application\ProductUnit\DeleteProductUnit\DeleteProductUnitService;
use App\Application\ProductUnit\DeleteProductUnit\DeleteProductUnitUseCase;
use App\Application\ProductUnit\GetProductSupplyUnits\GetProductSupplyUnitsService;
use App\Application\ProductUnit\GetProductSupplyUnits\GetProductSupplyUnitsUseCase;
use App\Application\ProductUnit\GetProductUnit\GetProductUnitService;
use App\Application\ProductUnit\GetProductUnit\GetProductUnitUseCase;
use App\Application\ProductUnit\GetProductUnits\GetProductUnitsService;
use App\Application\ProductUnit\GetProductUnits\GetProductUnitsUseCase;
use App\Application\ProductUnit\UpdateProductUnit\UpdateProductUnitService;
use App\Application\ProductUnit\UpdateProductUnit\UpdateProductUnitUseCase;
use App\Decorators\TransactionalBatchCreateProductUnitsUseCase;
use App\Decorators\TransactionalCreateProductUnitUseCase;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Repositories\ProductUnitRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ProductUnitProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductUnitRepository::class, ProductUnitRepositoryImpl::class);
        $this->app->singleton(GetProductUnitsUseCase::class, GetProductUnitsService::class);
        $this->app->singleton(GetProductUnitUseCase::class, GetProductUnitService::class);
        $this->app->singleton(GetProductSupplyUnitsUseCase::class, GetProductSupplyUnitsService::class);
        $this->app->bind(CreateProductUnitUseCase::class, function ($app) {
            return new TransactionalCreateProductUnitUseCase(
                $app->make(CreateProductUnitService::class),
            );
        });
        $this->app->bind(BatchCreateProductUnitsUseCase::class, function ($app) {
            return new TransactionalBatchCreateProductUnitsUseCase(
                $app->make(BatchCreateProductUnitsService::class),
            );
        });
        $this->app->singleton(UpdateProductUnitUseCase::class, UpdateProductUnitService::class);
        $this->app->singleton(DeleteProductUnitUseCase::class, DeleteProductUnitService::class);
    }
}
