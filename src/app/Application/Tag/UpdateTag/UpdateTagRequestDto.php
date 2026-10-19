<?php

declare(strict_types=1);

namespace App\Application\Tag\UpdateTag;

readonly class UpdateTagRequestDto
{
    public function __construct(
        public string $id,
        public string $alias,
        public ?int $sort,
        public string $name,
        public bool $active,
    ) {}
}
