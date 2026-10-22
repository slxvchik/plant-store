<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

use App\Domain\Media\Model\Image;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

/**
 * Should be transactional
 */
readonly class CreateImageService implements CreateImageUseCase
{
    /**
     * @param  string  $imageStorageRootPath  should be with slash in the end
     * @param  string  $webUploadImagePath  should be with slash in the end
     */
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private ImageRepository $imageRepository,
        private string $imageStorageRootPath,
        private string $webUploadImagePath
    ) {}

    /**
     * @throws InternalException
     */
    #[Override]
    public function execute(CreateImageRequestDto $createImageRequestDto): string
    {
        if (! empty($createImageRequestDto->media->error)) {
            throw new InternalException('Не удалось загрузить файл.');
        }

        $mimeParts = explode('/', $createImageRequestDto->media->mimeType);
        $fileExtension = end($mimeParts);

        $uniqueFileName = $this->uuidGeneratorInterface->generate().'.'.$fileExtension;

        $relativePath = $this->webUploadImagePath.$uniqueFileName;

        $image = Image::createNew(
            uuidGeneratorInterface: $this->uuidGeneratorInterface,
            webPathToFile: $relativePath,
            mimeType: $createImageRequestDto->media->mimeType,
            sizeInBytes: $createImageRequestDto->media->size,
            width: $createImageRequestDto->width,
            height: $createImageRequestDto->height,
            titleText: $createImageRequestDto->titleText,
            altText: $createImageRequestDto->altText
        );

        $absolutePath = $this->imageStorageRootPath.$image->webPathToFile;

        $directory = dirname($absolutePath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (! move_uploaded_file($createImageRequestDto->media->tmpName, $absolutePath)) {
            throw new InternalException('Не удалось загрузить файл.');
        }

        try {
            return $this->imageRepository->create($image);
        } catch (\Throwable $e) {
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
            }

            throw new InternalException('Не удалось сохранить данные изображения.');
        }
    }
}
