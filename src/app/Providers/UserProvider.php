<?php

namespace App\Providers;

use App\Application\User\CreateUser\CreateUserService;
use App\Application\User\CreateUser\CreateUserUseCase;
use App\Application\User\DeleteUser\DeleteUserService;
use App\Application\User\DeleteUser\DeleteUserUseCase;
use App\Application\User\GetUser\GetUserService;
use App\Application\User\GetUser\GetUserUseCase;
use App\Application\User\GetUsersPage\GetUsersPageService;
use App\Application\User\GetUsersPage\GetUsersPageUseCase;
use App\Application\User\UpdateUser\UpdateUserService;
use App\Application\User\UpdateUser\UpdateUserUseCase;
use App\Domain\User\Repository\UserRepository;
use App\Repositories\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserRepository::class,
            UserRepositoryImpl::class
        );

        $this->app->singleton(
            GetUsersPageUseCase::class,
            GetUsersPageService::class
        );

        $this->app->singleton(
            GetUserUseCase::class,
            GetUserService::class
        );

        $this->app->singleton(
            CreateUserUseCase::class,
            CreateUserService::class
        );

        $this->app->singleton(
            UpdateUserUseCase::class,
            UpdateUserService::class
        );

        $this->app->singleton(
            DeleteUserUseCase::class,
            DeleteUserService::class
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
