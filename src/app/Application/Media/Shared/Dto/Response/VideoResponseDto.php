<?php

declare(strict_types=1);

namespace App\Application\Media\Shared\Dto\Response;

use App\Domain\Media\Model\Video;
use JsonSerializable;
use Override;

readonly class VideoResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $webPathToFile,
        public string $mimeType,
        public int $sizeInBytes,
        public ?int $width,
        public ?int $height,
        public bool $loop,
        public bool $muted,
        public ?int $durationSec,
        public ?string $codec,
        public ?string $thumbnailId,
    ) {}

    public static function fromDomain(Video $video, string $webPathToFile): self
    {
        return new self(
            id: $video->id->value,
            webPathToFile: $webPathToFile,
            mimeType: $video->mimeType,
            sizeInBytes: $video->sizeInBytes,
            width: $video->width,
            height: $video->height,
            loop: $video->loop,
            muted: $video->muted,
            durationSec: $video->durationSec,
            codec: $video->codec,
            thumbnailId: $video->thumbnailId,
        );
    }

    /**
     * @return array{id: string, webPathToFile: string, mimeType: string, sizeInBytes: int, width: ?int, height: ?int, loop: bool, muted: bool, durationSec: ?int, codec: ?string, thumbnailId: ?string}
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
            'loop' => $this->loop,
            'muted' => $this->muted,
            'durationSec' => $this->durationSec,
            'codec' => $this->codec,
            'thumbnailId' => $this->thumbnailId,
        ];
    }
}
