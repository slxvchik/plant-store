<?php

namespace App\Application\MainPageGallery\UpdateSlide;

interface UpdateSlideUseCase
{
    /**
     * @throws \App\Application\MainPageGallery\Shared\Exception\SlideNotFoundException
     */
    public function execute(UpdateSlideRequestDto $updateSlideRequestDto): void;
}
