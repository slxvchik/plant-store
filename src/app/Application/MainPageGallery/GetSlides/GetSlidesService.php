<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use Override;

readonly class GetSlidesService implements GetSlidesUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository
    ) {}

    #[Override]
    public function execute(): array
    {
        $slides = $this->mainPageGalleryRepository->findAll();

        return array_map(
            fn ($slide): SlideResponseDto => SlideResponseDto::fromDomain($slide),
            $slides,
        );
    }
}
