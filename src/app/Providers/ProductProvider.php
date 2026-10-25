<?php

namespace App\Providers;

use App\Application\Product\CreateProduct\CreateProductService;
use App\Application\Product\CreateProduct\CreateProductUseCase;
use App\Application\Product\UpdateProduct\UpdateProductService;
use App\Application\Product\UpdateProduct\UpdateProductUseCase;
use App\Domain\Product\Repository\ProductRepository;
use App\Repositories\ProductRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ProductProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ProductRepository::class,
            ProductRepositoryImpl::class
        );

        $this->app->singleton(
            CreateProductUseCase::class,
            CreateProductService::class
        );

        $this->app->singleton(
            UpdateProductUseCase::class,
            UpdateProductService::class
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
