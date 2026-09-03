<?php

declare(strict_types=1);

namespace App\Application\Media\Dto\Request;

use App\Domain\Media\Models\Media;
use App\Application\Media\Exception\InvalidMimeTypeException;

readonly class CreateImageRequestDto
{
    public string $name;
    public string $mimeType;
    public string $tmpName;
    public int $size;
    public int $width;
    public int $height;
    public ?string $altText;

    public function __construct(Media $media, ?string $altText)
    {
        $this->name = $media->name;
        $this->mimeType = $media->mimeType;
        $this->tmpName = $media->tmpName;
        $this->size = $media->size;

        $imageSize = getimagesize($media->tmpName);

        if ($imageSize === false) {
            throw new InvalidMimeTypeException($media->mimeType, ['image/jpeg', 'image/png', 'image/webp']);
        }

        $this->width = $imageSize[0];
        $this->height = $imageSize[1];

        $this->altText = $altText;
    }
}
