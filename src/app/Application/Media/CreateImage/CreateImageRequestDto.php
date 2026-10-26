<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

use App\Domain\Media\Model\Media;
use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

readonly class CreateImageRequestDto
{
    public Media $media;

    public int $width;

    public int $height;

    public ?string $titleText;

    public ?string $altText;

    /**
     * @throws AppException
     */
    public function __construct(Media $media, ?string $altText, ?string $titleText)
    {
        $imageSize = getimagesize($media->tmpName);

        if ($imageSize === false) {
            throw new AppException(
                appExceptionStatus: AppExceptionStatus::INVALID_ARGUMENT,
                errorMessage: 'Не удалось прочитать размеры изображения.',
            );
        }

        $this->media = $media;
        $this->width = $imageSize[0];
        $this->height = $imageSize[1];
        $this->titleText = $titleText;
        $this->altText = $altText;
    }
}
