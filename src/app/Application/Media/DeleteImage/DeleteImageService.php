<?php

declare(strict_types=1);

namespace App\Application\Media\DeleteImage;

use App\Application\Media\Shared\Exception\ImageNotFoundException;
use App\Domain\Media\Repository\ImageRepository;
use Override;

readonly class DeleteImageService implements DeleteImageUseCase
{
    public function __construct(
        private ImageRepository $imageRepository,
        private string $imageStorageRootPath
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $image = $this->imageRepository->findById($id);
        if ($image === null) {
            throw new ImageNotFoundException();
        }

        $filePath = $this->imageStorageRootPath . $image->webPathToFile;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->imageRepository->delete($id);
    }
}
