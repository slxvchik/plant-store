<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Exception\InvalidMimeTypeException;
use App\Domain\Media\Model\Image;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;
use Throwable;

/**
 * Should be transactional
 */
readonly class CreateImageService implements CreateImageUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private ImageRepository $imageRepository,
        private FileStorageInterface $fileStorage,
    ) {}

    /**
     * @throws InternalException
     * @throws InvalidMimeTypeException
     */
    #[Override]
    public function execute(CreateImageRequestDto $createImageRequestDto): string
    {
        if (! empty($createImageRequestDto->media->error)) {
            throw new InternalException('Не удалось загрузить файл.');
        }

        $image = Image::createNew(
            uuidGeneratorInterface: $this->uuidGeneratorInterface,
            mimeType: $createImageRequestDto->media->mimeType,
            sizeInBytes: $createImageRequestDto->media->size,
            width: $createImageRequestDto->width,
            height: $createImageRequestDto->height,
            titleText: $createImageRequestDto->titleText,
            altText: $createImageRequestDto->altText
        );

        $isStored = $this->fileStorage->putFile(
            $createImageRequestDto->media->tmpName,
            $image->id->value
        );

        if (! $isStored) {
            throw new InternalException('Не удалось загрузить файл.');
        }

        try {
            return $this->imageRepository->create($image);
        } catch (Throwable $e) {
            if ($this->fileStorage->exists($image->id->value)) {
                $this->fileStorage->delete($image->id->value);
            }

            throw new InternalException('Не удалось сохранить данные изображения.');
        }
    }
}
