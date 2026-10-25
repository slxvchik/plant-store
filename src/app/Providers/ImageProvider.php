<?php

namespace App\Providers;

use App\Adapters\FileStorageImpl;
use App\Application\Media\CreateImage\CreateImageService;
use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Media\DeleteImage\DeleteImageService;
use App\Application\Media\DeleteImage\DeleteImageUseCase;
use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Repository\ImageRepository;
use App\Repositories\ImageRepositoryImpl;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class ImageProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ImageRepository::class,
            ImageRepositoryImpl::class,
        );

        $this->app->singleton(
            FileStorageInterface::class,
            FileStorageImpl::class,
        );

        $this->app->singleton(
            CreateImageUseCase::class,
            CreateImageService::class,
        );

        $this->app->singleton(
            DeleteImageUseCase::class,
            DeleteImageService::class,
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
