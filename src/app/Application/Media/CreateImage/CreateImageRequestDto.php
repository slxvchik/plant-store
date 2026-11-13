<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

use App\Application\Media\Shared\MediaFolder;
use App\Domain\Media\Model\MediaData;
use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

readonly class CreateImageRequestDto
{
    public MediaData $media;

    public int $width;

    public int $height;

    public ?string $titleText;

    public ?string $altText;

    public MediaFolder $folder;

    /**
     * @throws AppException
     */
    public function __construct(MediaData $media, ?string $altText, ?string $titleText, MediaFolder $folder)
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
        $this->folder = $folder;
    }
}
