<?php

namespace App\Providers;

use App\Application\UserRequest\DeleteUserRequest\DeleteUserRequestService;
use App\Application\UserRequest\DeleteUserRequest\DeleteUserRequestUseCase;
use App\Application\UserRequest\GetUserRequests\GetUserRequestsService;
use App\Application\UserRequest\GetUserRequests\GetUserRequestsUseCase;
use App\Application\UserRequest\SaveFormRequest\SaveFormRequestService;
use App\Application\UserRequest\SaveFormRequest\SaveFormRequestUseCase;
use App\Domain\UserRequest\UserRequestRepository;
use App\Repositories\UserRequestRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class UserRequestsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserRequestRepository::class,
            UserRequestRepositoryImpl::class,
        );

        $this->app->singleton(
            SaveFormRequestUseCase::class,
            SaveFormRequestService::class,
        );

        $this->app->singleton(
            GetUserRequestsUseCase::class,
            GetUserRequestsService::class,
        );

        $this->app->singleton(
            DeleteUserRequestUseCase::class,
            DeleteUserRequestService::class,
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
