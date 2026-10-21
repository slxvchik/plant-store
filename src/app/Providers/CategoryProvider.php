<?php

namespace App\Providers;

use App\Application\Category\CreateCategory\CreateCategoryService;
use App\Application\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\Category\DeleteCategory\DeleteCategoryService;
use App\Application\Category\DeleteCategory\DeleteCategoryUseCase;
use App\Application\Category\GetCategories\GetCategoriesService;
use App\Application\Category\GetCategories\GetCategoriesUseCase;
use App\Application\Category\UpdateCategory\UpdateCategoryService;
use App\Application\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Domain\Category\Repository\CategoryRepository;
use App\Repositories\CategoryRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CategoryRepository::class,
            CategoryRepositoryImpl::class
        );

        $this->app->singleton(
            GetCategoriesUseCase::class,
            GetCategoriesService::class
        );

        $this->app->singleton(
            CreateCategoryUseCase::class,
            CreateCategoryService::class
        );

        $this->app->singleton(
            UpdateCategoryUseCase::class,
            UpdateCategoryService::class
        );

        $this->app->singleton(
            DeleteCategoryUseCase::class,
            DeleteCategoryService::class
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
