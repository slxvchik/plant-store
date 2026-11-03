<?php

declare(strict_types=1);

namespace App\Domain\Media\Model;

use App\Application\Media\Shared\MediaFolder;
use App\Domain\Media\Exception\InvalidMimeTypeException;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Image extends MediaDB
{
    public private(set) ?int $width;

    public private(set) ?int $height;

    public private(set) ?string $titleText;

    public private(set) ?string $altText;

    /**
     * @var string[]
     */
    private const array ACCEPTABLE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    /**
     * @throws InvalidMimeTypeException
     */
    private function __construct(
        Uuid $id,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $titleText,
        ?string $altText,
        MediaFolder $folder,
    ) {
        if (! in_array($mimeType, self::ACCEPTABLE_TYPES)) {
            throw new InvalidMimeTypeException($mimeType, self::ACCEPTABLE_TYPES);
        }

        parent::__construct($id, $mimeType, $sizeInBytes, $folder);

        $this->width = $width;
        $this->height = $height;
        $this->titleText = $titleText;
        $this->altText = $altText;
    }

    public static function fromDb(
        string $id,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $titleText,
        ?string $altText,
        MediaFolder $folder,
    ): self {
        return new self(
            id: new Uuid($id),
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            titleText: $titleText,
            altText: $altText,
            folder: $folder,
        );
    }

    /**
     * @throws InvalidMimeTypeException
     */
    public static function createNew(
        UuidGeneratorInterface $uuidGeneratorInterface,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        ?string $titleText,
        ?string $altText,
        MediaFolder $folder,
    ): self {
        $uuidStr = $uuidGeneratorInterface->generate();

        return new self(
            id: new Uuid($uuidStr),
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            titleText: $titleText,
            altText: $altText,
            folder: $folder,
        );
    }

    public function update(?string $titleText, ?string $altText): void
    {
        $this->titleText = $titleText;
        $this->altText = $altText;
    }

    /**
     * @throws InternalException
     */
    public function getExtension(): string
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        if (! isset($mimeMap[$this->mimeType])) {
            throw new InternalException("Неподдерживаемый MIME-тип: {$this->mimeType}");
        }

        return $mimeMap[$this->mimeType];
    }

    /**
     * @throws InternalException
     */
    public function getFilename(): string
    {
        return $this->id->value.'.'.$this->getExtension();
    }

    /**
     * @throws InternalException
     */
    public function getFilePath(): string
    {
        return $this->folder->value.$this->getFilename();
    }
}
