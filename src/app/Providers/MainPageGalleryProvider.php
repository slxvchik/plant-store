<?php

namespace App\Providers;

use App\Application\MainPageGallery\CreateSlide\CreateSlideService;
use App\Application\MainPageGallery\CreateSlide\CreateSlideUseCase;
use App\Application\MainPageGallery\DeleteSlide\DeleteSlideService;
use App\Application\MainPageGallery\DeleteSlide\DeleteSlideUseCase;
use App\Application\MainPageGallery\GetSlides\GetSlidesService;
use App\Application\MainPageGallery\GetSlides\GetSlidesUseCase;
use App\Application\MainPageGallery\UpdateSlide\UpdateSlideService;
use App\Application\MainPageGallery\UpdateSlide\UpdateSlideUseCase;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use App\Repositories\MainPageGalleryRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class MainPageGalleryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            MainPageGalleryRepository::class,
            MainPageGalleryRepositoryImpl::class
        );

        $this->app->singleton(
            CreateSlideUseCase::class,
            CreateSlideService::class
        );

        $this->app->singleton(
            GetSlidesUseCase::class,
            GetSlidesService::class
        );

        $this->app->singleton(
            UpdateSlideUseCase::class,
            UpdateSlideService::class
        );

        $this->app->singleton(
            DeleteSlideUseCase::class,
            DeleteSlideService::class
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
