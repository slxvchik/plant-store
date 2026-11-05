<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetActiveSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;
use App\Application\Media\GetImagesByIds\GetImagesByIdsUseCase;
use App\Domain\MainPageGallery\Model\MainPageGallery;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use Override;

readonly class GetActiveSlidesService implements GetActiveSlidesUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository,
        private GetImagesByIdsUseCase $getImagesByIdsUseCase,
    ) {}

    #[Override]
    public function execute(): array
    {
        $slides = $this->mainPageGalleryRepository->search(
            active: true
        );

        $imageIds = array_map(fn (MainPageGallery $slide) => $slide->imageId, $slides);

        $images = $this->getImagesByIdsUseCase->execute($imageIds);
        $imagesMap = [];
        foreach ($images as $image) {
            $imagesMap[$image->id] = $image;
        }

        return array_map(
            function (MainPageGallery $slide) use ($imagesMap) {
                return $imagesMap[$slide->imageId] ? SlideResponseDto::fromDomain($slide, $imagesMap[$slide->imageId]) : null;
            },
            $slides,
        ) |> array_filter(...);
    }
}
