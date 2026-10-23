<?php

declare(strict_types=1);

namespace App\Application\Media\Shared\Dto\Response;

use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Model\Image;

readonly class ImageResponseDto
{
    public function __construct(
        public string $id,
        public string $webPathToFile,
        public string $mimeType,
        public int $sizeInBytes,
        public int $width,
        public int $height,
        public ?string $titleText,
        public ?string $altText
    ) {}

    public static function fromDomain(Image $image, string $webPathToFile): self
    {
        return new self(
            id: $image->id->value,
            webPathToFile: $webPathToFile,
            mimeType: $image->mimeType,
            sizeInBytes: $image->sizeInBytes,
            width: $image->width,
            height: $image->height,
            titleText: $image->titleText,
            altText: $image->altText
        );
    }
}
