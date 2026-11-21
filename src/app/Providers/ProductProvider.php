<?php

namespace App\Providers;

use App\Adapters\ProductDetailsFetcherImpl;
use App\Application\Product\CreateProduct\CreateProductService;
use App\Application\Product\CreateProduct\CreateProductUseCase;
use App\Application\Product\DeleteProduct\DeleteProductService;
use App\Application\Product\DeleteProduct\DeleteProductUseCase;
use App\Application\Product\GetDetailProduct\GetDetailProductService;
use App\Application\Product\GetDetailProduct\GetDetailProductUseCase;
use App\Application\Product\GetFeaturedProducts\GetFeaturedProductsService;
use App\Application\Product\GetFeaturedProducts\GetFeaturedProductsUseCase;
use App\Application\Product\GetProducts\GetProductsService;
use App\Application\Product\GetProducts\GetProductsUseCase;
use App\Application\Product\GetProductOptions\GetProductOptionsService;
use App\Application\Product\GetProductOptions\GetProductOptionsUseCase;
use App\Application\Product\SearchProducts\SearchProductsService;
use App\Application\Product\SearchProducts\SearchProductsUseCase;
use App\Application\Product\Shared\Port\ProductDetailsFetcher;
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
            ProductDetailsFetcher::class,
            ProductDetailsFetcherImpl::class,
        );

        $this->app->singleton(
            GetDetailProductUseCase::class,
            GetDetailProductService::class,
        );

        $this->app->singleton(
            GetProductsUseCase::class,
            GetProductsService::class,
        );

        $this->app->singleton(
            GetProductOptionsUseCase::class,
            GetProductOptionsService::class,
        );

        $this->app->singleton(
            CreateProductUseCase::class,
            CreateProductService::class,
        );

        $this->app->singleton(
            UpdateProductUseCase::class,
            UpdateProductService::class,
        );

        $this->app->singleton(
            DeleteProductUseCase::class,
            DeleteProductService::class,
        );

        $this->app->singleton(
            GetFeaturedProductsUseCase::class,
            GetFeaturedProductsService::class,
        );

        $this->app->singleton(
            SearchProductsUseCase::class,
            SearchProductsService::class,
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
