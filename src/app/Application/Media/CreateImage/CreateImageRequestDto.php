<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

use App\Domain\Media\Model\Media;

readonly class CreateImageRequestDto
{
    public Media $media;
    public int $width;
    public int $height;
    public ?string $altText;

    public function __construct(Media $media, ?string $altText)
    {
        $this->media = $media;

        $imageSize = getimagesize($media->tmpName);

        $this->width = $imageSize[0];
        $this->height = $imageSize[1];

        $this->altText = $altText;
    }
}
