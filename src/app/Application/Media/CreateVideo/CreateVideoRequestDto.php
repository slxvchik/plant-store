<?php

declare(strict_types=1);

namespace App\Application\Media\CreateVideo;

use App\Domain\Media\Model\MediaData;

readonly class CreateVideoRequestDto
{
    public function __construct(
        public MediaData $media,
        public ?int      $width,
        public ?int      $height,
        public bool      $loop,
        public bool      $muted,
        public ?int      $durationSec,
        public ?string   $codec,
        public ?string   $thumbnailId
    ) {}
}
