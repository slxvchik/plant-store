<?php

declare(strict_types=1);

namespace App\Application\Media\Dto\Request;

use App\Domain\Media\Model\Media;

readonly class CreateVideoRequestDto
{
    public function __construct(
        public Media $media,
        public ?int $width,
        public ?int $height,
        public bool $loop,
        public bool $muted,
        public ?int $durationSec,
        public ?string $codec,
        public ?string $thumbnailId
    ) {}
}
