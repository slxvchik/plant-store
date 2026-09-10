<?php

declare(strict_types=1);

namespace App\Application\Media\Shared\Dto\Response;

use App\Domain\Media\Model\Video;

readonly class VideoResponseDto
{
    public function __construct(
        public string $id,
        public string $pathToFile,
        public string $originalName,
        public string $mimeType,
        public int $sizeInBytes,
        public ?int $width,
        public ?int $height,
        public bool $loop,
        public bool $muted,
        public ?int $durationSec,
        public ?string $codec,
        public ?string $thumbnailId
    ) {}

    public static function fromDomain(Video $video): self
    {
        return new self(
            id: $video->id->value,
            pathToFile: $video->pathToFile,
            originalName: $video->originalName,
            mimeType: $video->mimeType,
            sizeInBytes: $video->sizeInBytes,
            width: $video->width,
            height: $video->height,
            loop: $video->loop,
            muted: $video->muted,
            durationSec: $video->durationSec,
            codec: $video->codec,
            thumbnailId: $video->thumbnailId
        );
    }
}
