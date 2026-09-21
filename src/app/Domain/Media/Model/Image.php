<?php

declare(strict_types=1);

namespace App\Domain\Media\Model;

use App\Domain\Media\Exception\InvalidMimeTypeException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Image extends MediaDB
{
    private(set) int $width;
    private(set) int $height;
    private(set) ?string $titleText;
    private(set) ?string $altText;
    /**
     * @var string[]
     */
    private const array ACCEPTABLE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    private function __construct(
        Uuid    $id,
        string  $webPathToFile,
        string  $mimeType,
        int     $sizeInBytes,
        int     $width,
        int     $height,
        ?string $titleText,
        ?string $altText
    ) {
        if (in_array($mimeType, self::ACCEPTABLE_TYPES)) {
            throw new InvalidMimeTypeException($mimeType, self::ACCEPTABLE_TYPES);
        }

        parent::__construct($id, $webPathToFile, $mimeType, $sizeInBytes);

        $this->width = $width;
        $this->height = $height;
        $this->titleText = $titleText;
        $this->altText = $altText;
    }

    public static function fromDb(
        string $id,
        string $webPathToFile,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $titleText,
        ?string $altText
    ): self {
        return new self(
            id: new Uuid($id),
            webPathToFile: $webPathToFile,
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            titleText: $titleText,
            altText: $altText
        );
    }

    public static function createNew(
        UuidGeneratorInterface $uuidGeneratorInterface,
        string $webPathToFile,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $titleText,
        ?string $altText
    ): self {
        $uuidStr = $uuidGeneratorInterface->generate();
        return new self(
            id: new Uuid($uuidStr),
            webPathToFile: $webPathToFile,
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            titleText: $titleText,
            altText: $altText
        );
    }

    public function update(?string $titleText, ?string $altText): void
    {
        $this->titleText = $titleText;
        $this->altText = $altText;
    }
}
