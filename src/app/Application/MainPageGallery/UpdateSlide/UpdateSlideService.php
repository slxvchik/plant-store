<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\UpdateSlide;

use App\Application\MainPageGallery\Shared\Exception\SlideNotFoundException;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use Override;

readonly class UpdateSlideService implements UpdateSlideUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository
    ) {}

    /**
     * @throws SlideNotFoundException
     */
    #[Override]
    public function execute(UpdateSlideRequestDto $updateSlideRequestDto): void
    {
        $slide = $this->mainPageGalleryRepository->findById($updateSlideRequestDto->id);
        if ($slide === null) {
            throw new SlideNotFoundException;
        }

        $slide->update(
            sort: $updateSlideRequestDto->sort,
            imageId: $updateSlideRequestDto->imageId ?? $slide->imageId,
            preTitle: $updateSlideRequestDto->preTitle,
            title: $updateSlideRequestDto->title,
            description: $updateSlideRequestDto->description,
            buttonLink: $updateSlideRequestDto->buttonLink,
            buttonText: $updateSlideRequestDto->buttonText,
        );

        $this->mainPageGalleryRepository->update($slide);
    }
}
