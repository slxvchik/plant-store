<?php

declare(strict_types=1);

namespace App\Application\Tag\CreateTag;

readonly class CreateTagRequestDto
{
    public function __construct(
        public string $alias,
        public ?int $sort,
        public string $name,
        public bool $active,
    ) {}
}
