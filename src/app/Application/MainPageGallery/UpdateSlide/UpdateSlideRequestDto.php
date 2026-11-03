<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\UpdateSlide;

readonly class UpdateSlideRequestDto
{
    public function __construct(
        public string $id,
        public int $sort,
        public ?string $imageId,
        public ?string $preTitle,
        public ?string $title,
        public ?string $description,
        public ?string $buttonLink,
        public ?string $buttonText,
    ) {}
}
