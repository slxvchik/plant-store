<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\CreateSlide;

readonly class CreateSlideRequestDto
{
    public function __construct(
        public int $sort,
        public string $imageId,
        public ?string $preTitle,
        public ?string $title,
        public ?string $description,
        public ?string $buttonLink,
        public ?string $buttonText,
    ) {}
}
