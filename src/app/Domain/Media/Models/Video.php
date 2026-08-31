<?php

declare(strict_types=1);

namespace App\Domain\Media\Models;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Video extends MediaFile
{
    private(set) int $width;
    private(set) int $height;
    private(set) bool $loop;
    private(set) bool $muted;
    private(set) int $durationSec;
    private(set) ?string $codec;
    private(set) ?string $thumbnailId;

    private function __construct(
        Uuid $id,
        string $pathToFile,
        string $originalName,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        bool $loop,
        bool $muted,
        int $durationSec,
        ?string $codec,
        ?string $thumbnailId
    ) {
        parent::__construct($id, $pathToFile, $originalName, $mimeType, $sizeInBytes);

        $this->width = $width;
        $this->height = $height;
        $this->loop = $loop;
        $this->muted = $muted;
        $this->durationSec = $durationSec;
        $this->codec = $codec;
        $this->thumbnailId = $thumbnailId;
    }

    public static function fromDb(
        string $id,
        string $pathToFile,
        string $originalName,
        string $mimeType,
        int $sizeInBytes,
        int $width,
        int $height,
        bool $loop,
        bool $muted,
        int $durationSec,
        ?string $codec,
        ?string $thumbnailId
    ): self {
        return new self(
            id: new Uuid($id),
            pathToFile: $pathToFile,
            originalName: $originalName,
            mimeType: $mimeType,
            sizeInBytes: $sizeInBytes,
            width: $width,
            height: $height,
            loop: $loop,
            muted: $muted,
            durationSec: $durationSec,
            codec: $codec,
            thumbnailId: $thumbnailId
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
        bool $loop,
        bool $muted,
        int $durationSec,
        ?string $codec,
        ?string $thumbnailId
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
            loop: $loop,
            muted: $muted,
            durationSec: $durationSec,
            codec: $codec,
            thumbnailId: $thumbnailId
        );
    }

    public function update(?string $thumbnailId, bool $loop, bool $muted): void
    {
        $this->thumbnailId = $thumbnailId;
        $this->loop = $loop;
        $this->muted = $muted;
    }
}
