<?php

declare(strict_types=1);

namespace App\Application\Media\UpdateVideo;

readonly class UpdateVideoRequestDto
{
    public function __construct(
        public string $id,
        public bool $loop,
        public bool $muted,
        public ?string $thumbnailId
    ) {}
}
