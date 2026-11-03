<?php

namespace App\Providers;

use App\Application\News\CreateNews\CreateNewsService;
use App\Application\News\CreateNews\CreateNewsUseCase;
use App\Application\News\DeleteNews\DeleteNewsService;
use App\Application\News\DeleteNews\DeleteNewsUseCase;
use App\Application\News\GetNews\GetNewsService;
use App\Application\News\GetNews\GetNewsUseCase;
use App\Application\News\GetNewsPage\GetNewsPageService;
use App\Application\News\GetNewsPage\GetNewsPageUseCase;
use App\Application\News\UpdateNews\UpdateNewsService;
use App\Application\News\UpdateNews\UpdateNewsUseCase;
use App\Domain\News\Repository\NewsRepository;
use App\Repositories\NewsRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class NewsProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            NewsRepository::class,
            NewsRepositoryImpl::class
        );

        $this->app->singleton(
            CreateNewsUseCase::class,
            CreateNewsService::class
        );

        $this->app->singleton(
            GetNewsPageUseCase::class,
            GetNewsPageService::class
        );

        $this->app->singleton(
            GetNewsUseCase::class,
            GetNewsService::class
        );

        $this->app->singleton(
            UpdateNewsUseCase::class,
            UpdateNewsService::class
        );

        $this->app->singleton(
            DeleteNewsUseCase::class,
            DeleteNewsService::class
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
