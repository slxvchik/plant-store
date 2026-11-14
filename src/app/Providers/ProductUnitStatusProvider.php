<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\ProductUnitStatus\CreateProductUnitStatus\CreateProductUnitStatusService;
use App\Application\ProductUnitStatus\CreateProductUnitStatus\CreateProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\DeleteProductUnitStatus\DeleteProductUnitStatusService;
use App\Application\ProductUnitStatus\DeleteProductUnitStatus\DeleteProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\GetProductUnitStatus\GetProductUnitStatusService;
use App\Application\ProductUnitStatus\GetProductUnitStatus\GetProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\GetProductUnitStatuses\GetProductUnitStatusesService;
use App\Application\ProductUnitStatus\GetProductUnitStatuses\GetProductUnitStatusesUseCase;
use App\Application\ProductUnitStatus\UpdateProductUnitStatus\UpdateProductUnitStatusService;
use App\Application\ProductUnitStatus\UpdateProductUnitStatus\UpdateProductUnitStatusUseCase;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use App\Repositories\ProductUnitStatusRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ProductUnitStatusProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductUnitStatusRepository::class, ProductUnitStatusRepositoryImpl::class);
        $this->app->singleton(GetProductUnitStatusesUseCase::class, GetProductUnitStatusesService::class);
        $this->app->singleton(GetProductUnitStatusUseCase::class, GetProductUnitStatusService::class);
        $this->app->singleton(CreateProductUnitStatusUseCase::class, CreateProductUnitStatusService::class);
        $this->app->singleton(UpdateProductUnitStatusUseCase::class, UpdateProductUnitStatusService::class);
        $this->app->singleton(DeleteProductUnitStatusUseCase::class, DeleteProductUnitStatusService::class);
    }
}
