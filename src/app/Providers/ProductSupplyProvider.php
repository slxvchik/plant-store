<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\ProductSupply\CreateProductSupply\CreateProductSupplyService;
use App\Application\ProductSupply\CreateProductSupply\CreateProductSupplyUseCase;
use App\Application\ProductSupply\DeleteProductSupply\DeleteProductSupplyService;
use App\Application\ProductSupply\DeleteProductSupply\DeleteProductSupplyUseCase;
use App\Application\ProductSupply\GetAllProductSupplies\GetAllProductSuppliesService;
use App\Application\ProductSupply\GetAllProductSupplies\GetAllProductSuppliesUseCase;
use App\Application\ProductSupply\GetProductSupply\GetProductSupplyService;
use App\Application\ProductSupply\GetProductSupply\GetProductSupplyUseCase;
use App\Application\ProductSupply\GetProductSupplies\GetProductSuppliesService;
use App\Application\ProductSupply\GetProductSupplies\GetProductSuppliesUseCase;
use App\Application\ProductSupply\UpdateProductSupply\UpdateProductSupplyService;
use App\Application\ProductSupply\UpdateProductSupply\UpdateProductSupplyUseCase;
use App\Domain\ProductSupply\ProductSupplyRepository;
use App\Repositories\ProductSupplyRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ProductSupplyProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ProductSupplyRepository::class, ProductSupplyRepositoryImpl::class);
        $this->app->singleton(GetProductSuppliesUseCase::class, GetProductSuppliesService::class);
        $this->app->singleton(GetAllProductSuppliesUseCase::class, GetAllProductSuppliesService::class);
        $this->app->singleton(GetProductSupplyUseCase::class, GetProductSupplyService::class);
        $this->app->singleton(CreateProductSupplyUseCase::class, CreateProductSupplyService::class);
        $this->app->singleton(UpdateProductSupplyUseCase::class, UpdateProductSupplyService::class);
        $this->app->singleton(DeleteProductSupplyUseCase::class, DeleteProductSupplyService::class);
    }
}
