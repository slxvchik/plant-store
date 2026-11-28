<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;
use App\Application\Media\GetImagesByIds\GetImagesByIdsUseCase;
use App\Domain\MainPageGallery\MainPageGalleryModel;
use App\Domain\MainPageGallery\MainPageGalleryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetSlidesService implements GetSlidesUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository,
        private GetImagesByIdsUseCase $getImagesByIdsUseCase,
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $slidesPage = $this->mainPageGalleryRepository->findPage($pageable);
        $slides = $slidesPage->items;

        $imageIds = array_map(fn (MainPageGalleryModel $slide) => $slide->imageId, $slides);

        $images = $this->getImagesByIdsUseCase->execute($imageIds);
        $imagesMap = [];
        foreach ($images as $image) {
            $imagesMap[$image->id] = $image;
        }

        $slideResponses = array_map(
            function (MainPageGalleryModel $slide) use ($imagesMap) {
                return SlideResponseDto::fromDomain($slide, $imagesMap[$slide->imageId] ?? null);
            },
            $slides,
        );

        return $slidesPage->changeItems($slideResponses);
    }
}
