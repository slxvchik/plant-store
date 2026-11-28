<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetActiveSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;

interface GetActiveSlidesUseCase
{
    /**
     * @return SlideResponseDto[]
     */
    public function execute(): array;
}
