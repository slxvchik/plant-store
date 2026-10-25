<?php

namespace App\Providers;

use App\Application\Category\CreateCategory\CreateCategoryService;
use App\Application\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\Category\DeleteCategory\DeleteCategoryService;
use App\Application\Category\DeleteCategory\DeleteCategoryUseCase;
use App\Application\Category\GetAllCategories\GetAllCategoriesService;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Category\GetCategoriesPage\GetCategoriesPageService;
use App\Application\Category\GetCategoriesPage\GetCategoriesPageUseCase;
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
            GetCategoriesPageUseCase::class,
            GetCategoriesPageService::class
        );

        $this->app->singleton(
            GetAllCategoriesUseCase::class,
            GetAllCategoriesService::class
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
