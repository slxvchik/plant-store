<?php

namespace App\Providers;

use App\Application\Product\CreateProduct\CreateProductService;
use App\Application\Product\CreateProduct\CreateProductUseCase;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
