<?php

namespace App\Providers;

use App\Application\Cart\CreateCart\CreateCartService;
use App\Application\Cart\CreateCart\CreateCartUseCase;
use App\Application\Cart\DeleteProduct\DeleteProductService;
use App\Application\Cart\DeleteProduct\DeleteProductUseCase;
use App\Application\Cart\GetUserCart\GetUserCartService;
use App\Application\Cart\GetUserCart\GetUserCartUseCase;
use App\Application\Cart\SaveProduct\SaveProductService;
use App\Application\Cart\SaveProduct\SaveProductUseCase;
use App\Domain\Cart\Repository\CartRepository;
use App\Repositories\CartRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class CartProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CartRepository::class,
            CartRepositoryImpl::class
        );

        $this->app->singleton(
            CreateCartUseCase::class,
            CreateCartService::class
        );

        $this->app->singleton(
            GetUserCartUseCase::class,
            GetUserCartService::class
        );

        $this->app->singleton(
            SaveProductUseCase::class,
            SaveProductService::class
        );

        $this->app->singleton(
            DeleteProductUseCase::class,
            DeleteProductService::class
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
