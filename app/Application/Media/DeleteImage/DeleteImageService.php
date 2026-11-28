<?php

declare(strict_types=1);

namespace App\Application\Media\DeleteImage;

use App\Application\Media\Shared\Exception\ImageNotFoundException;
use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Repository\ImageRepository;
use Override;

readonly class DeleteImageService implements DeleteImageUseCase
{
    public function __construct(
        private ImageRepository $imageRepository,
        private FileStorageInterface $fileStorage,
    ) {}

    /**
     * @throws ImageNotFoundException
     */
    #[Override]
    public function execute(string $id): void
    {
        $image = $this->imageRepository->findById($id);
        if ($image === null) {
            throw new ImageNotFoundException;
        }

        if ($this->fileStorage->exists($image->id->value)) {
            $this->fileStorage->delete($image->id->value);
        }

        $this->imageRepository->delete($id);
    }
}
