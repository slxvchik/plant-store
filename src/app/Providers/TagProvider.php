<?php

namespace App\Providers;

use App\Application\Tag\CreateTag\CreateTagService;
use App\Application\Tag\CreateTag\CreateTagUseCase;
use App\Application\Tag\DeleteTag\DeleteTagService;
use App\Application\Tag\DeleteTag\DeleteTagUseCase;
use App\Application\Tag\GetTags\GetTagsService;
use App\Application\Tag\GetTags\GetTagsUseCase;
use App\Application\Tag\UpdateTag\UpdateTagService;
use App\Application\Tag\UpdateTag\UpdateTagUseCase;
use App\Domain\Tag\Repository\TagRepository;
use App\Repositories\TagRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class TagProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            TagRepository::class,
            TagRepositoryImpl::class
        );

        $this->app->singleton(
            GetTagsUseCase::class,
            GetTagsService::class
        );

        $this->app->singleton(
            CreateTagUseCase::class,
            CreateTagService::class
        );

        $this->app->singleton(
            UpdateTagUseCase::class,
            UpdateTagService::class
        );

        $this->app->singleton(
            DeleteTagUseCase::class,
            DeleteTagService::class
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
