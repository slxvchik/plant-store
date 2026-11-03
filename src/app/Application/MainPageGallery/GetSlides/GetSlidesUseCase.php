<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;

interface GetSlidesUseCase
{
    /**
     * @return SlideResponseDto[]
     */
    public function execute(): array;
}
