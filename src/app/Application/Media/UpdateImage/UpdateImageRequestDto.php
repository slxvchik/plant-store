<?php

declare(strict_types=1);

namespace App\Application\Media\UpdateImage;

readonly class UpdateImageRequestDto
{
    public function __construct(
        public string $id,
        public ?string $altText
    ) {}
}
