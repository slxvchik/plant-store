<?php

declare(strict_types=1);

namespace App\Application\Media\Shared\Dto\Response;

use App\Domain\Media\Model\Image;
use JsonSerializable;
use Override;

readonly class ImageResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $webPathToFile,
        public string $mimeType,
        public int $sizeInBytes,
        public ?int $width,
        public ?int $height,
        public ?string $titleText,
        public ?string $altText,
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
            altText: $image->altText,
        );
    }

    /**
     * @return array{id: string, webPathToFile: string, mimeType: string, sizeInBytes: int, width: ?int, height: ?int, titleText: ?string, altText: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'webPathToFile' => $this->webPathToFile,
            'mimeType' => $this->mimeType,
            'sizeInBytes' => $this->sizeInBytes,
            'width' => $this->width,
            'height' => $this->height,
            'titleText' => $this->titleText,
            'altText' => $this->altText,
        ];
    }
}
