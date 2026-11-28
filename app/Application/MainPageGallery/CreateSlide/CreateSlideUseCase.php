<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\CreateSlide;

interface CreateSlideUseCase
{
    public function execute(CreateSlideRequestDto $createSlideRequestDto): string;
}
