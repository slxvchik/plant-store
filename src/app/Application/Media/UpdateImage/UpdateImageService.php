<?php

declare(strict_types=1);

namespace App\Application\Media\UpdateImage;

use App\Application\Media\Shared\Exception\ImageNotFoundException;
use App\Domain\Media\Repository\ImageRepository;
use Override;

readonly class UpdateImageService implements UpdateImageUseCase
{
    public function __construct(
        private ImageRepository $imageRepository
    ) {}

    #[Override]
    public function execute(UpdateImageRequestDto $updateImageRequestDto): void
    {
        $image = $this->imageRepository->findById($updateImageRequestDto->id);
        if ($image === null) {
            throw new ImageNotFoundException();
        }

        $image->update(
            titleText: $updateImageRequestDto->titleText,
            altText: $updateImageRequestDto->altText
        );

        $this->imageRepository->update($image);
    }
}
