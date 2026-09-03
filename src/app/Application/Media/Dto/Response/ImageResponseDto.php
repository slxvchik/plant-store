<?php

declare(strict_types=1);

namespace App\Application\Media\Dto\Response;

use App\Domain\Media\Models\Image;

readonly class ImageResponseDto
{
    public function __construct(
        public string $id,
        public string $pathToFile,
        public string $originalName,
        public string $mimeType,
        public int $sizeInBytes,
        public int $width,
        public int $height,
        public ?string $altText
    ) {}

    public static function fromDomain(Image $image): self
    {
        return new self(
            id: $image->id->value,
            pathToFile: $image->pathToFile,
            originalName: $image->originalName,
            mimeType: $image->mimeType,
            sizeInBytes: $image->sizeInBytes,
            width: $image->width,
            height: $image->height,
            altText: $image->altText,
        );
    }
}
