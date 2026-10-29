<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\CreateSlide;

use App\Domain\MainPageGallery\Model\MainPageGallery;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateSlideService implements CreateSlideUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Override]
    public function execute(CreateSlideRequestDto $createSlideRequestDto): string
    {
        $slide = MainPageGallery::createNew(
            uuidGeneratorInterface: $this->uuidGenerator,
            sort: $createSlideRequestDto->sort,
            imageId: $createSlideRequestDto->imageId,
            preTitle: $createSlideRequestDto->preTitle,
            title: $createSlideRequestDto->title,
            description: $createSlideRequestDto->description,
            buttonLink: $createSlideRequestDto->buttonLink,
            buttonText: $createSlideRequestDto->buttonText,
        );

        return $this->mainPageGalleryRepository->create($slide);
    }
}
