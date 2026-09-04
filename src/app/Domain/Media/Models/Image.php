<?php

declare(strict_types=1);

namespace App\Domain\Media\Models;

use App\Domain\Media\Exception\InvalidMimeTypeException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Image extends MediaDB
{
    private(set) int $width;
    private(set) int $height;
    private(set) ?string $altText;
    private const ACCEPTABLE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    private function __construct(
        Uuid $id,
        string $pathToFile,
        string $originalName,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $altText
    ) {
        if (in_array($mimeType, self::ACCEPTABLE_TYPES)) {
            throw new InvalidMimeTypeException($mimeType, self::ACCEPTABLE_TYPES);
        }

        parent::__construct($id, $pathToFile, $originalName, $mimeType, $sizeInBytes);

        $this->width = $width;
        $this->height = $height;
        $this->altText = $altText;
    }

    public static function fromDb(
        string $id,
        string $pathToFile,
        string $originalName,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $altText
    ): self {
        return new self(
            id: new Uuid($id),
            pathToFile: $pathToFile,
            originalName: $originalName,
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            altText: $altText
        );
    }

    public static function createNew(
        UuidGeneratorInterface $uuidGeneratorInterface,
        string $pathToFile,
        string $originalName,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $altText
    ): self {
        $uuidStr = $uuidGeneratorInterface->generate();
        return new self(
            id: new Uuid($uuidStr),
            pathToFile: $pathToFile,
            originalName: $originalName,
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            altText: $altText
        );
    }

    public function update(?string $altText): void
    {
        $this->altText = $altText;
    }
}
