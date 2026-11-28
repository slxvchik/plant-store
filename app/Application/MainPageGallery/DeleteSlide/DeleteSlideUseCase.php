<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\DeleteSlide;

interface DeleteSlideUseCase
{
    /**
     * @throws \App\Application\MainPageGallery\Shared\Exception\SlideNotFoundException
     */
    public function execute(string $id): void;
}
