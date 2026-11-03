<?php

namespace App\Providers;

use App\Application\Order\CancelOrder\CancelOrderService;
use App\Application\Order\CancelOrder\CancelOrderUseCase;
use App\Application\Order\CompleteOrder\CompleteOrderService;
use App\Application\Order\CompleteOrder\CompleteOrderUseCase;
use App\Application\Order\CreateOrder\CreateOrderService;
use App\Application\Order\CreateOrder\CreateOrderUseCase;
use App\Application\Order\CreateOrderForUser\CreateOrderForUserService;
use App\Application\Order\CreateOrderForUser\CreateOrderForUserUseCase;
use App\Application\Order\DeleteOrder\DeleteOrderService;
use App\Application\Order\DeleteOrder\DeleteOrderUseCase;
use App\Application\Order\GetOrder\GetOrderService;
use App\Application\Order\GetOrder\GetOrderUseCase;
use App\Application\Order\GetOrders\GetOrdersService;
use App\Application\Order\GetOrders\GetOrdersUseCase;
use App\Application\Order\GetUserOrders\GetUserOrdersService;
use App\Application\Order\GetUserOrders\GetUserOrdersUseCase;
use App\Application\Order\TakeOrderIntoWork\TakeOrderIntoWorkService;
use App\Application\Order\TakeOrderIntoWork\TakeOrderIntoWorkUseCase;
use App\Domain\Order\Repository\OrderRepository;
use App\Repositories\OrderRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class OrderProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            OrderRepository::class,
            OrderRepositoryImpl::class
        );

        $this->app->singleton(
            CreateOrderUseCase::class,
            CreateOrderService::class
        );

        $this->app->singleton(
            CreateOrderForUserUseCase::class,
            CreateOrderForUserService::class
        );

        $this->app->singleton(
            GetOrdersUseCase::class,
            GetOrdersService::class
        );

        $this->app->singleton(
            GetOrderUseCase::class,
            GetOrderService::class
        );

        $this->app->singleton(
            GetUserOrdersUseCase::class,
            GetUserOrdersService::class
        );

        $this->app->singleton(
            TakeOrderIntoWorkUseCase::class,
            TakeOrderIntoWorkService::class
        );

        $this->app->singleton(
            CancelOrderUseCase::class,
            CancelOrderService::class
        );

        $this->app->singleton(
            CompleteOrderUseCase::class,
            CompleteOrderService::class
        );

        $this->app->singleton(
            DeleteOrderUseCase::class,
            DeleteOrderService::class
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
