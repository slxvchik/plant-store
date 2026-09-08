<?php

declare(strict_types=1);

namespace App\Application\Tag\Dto\Request;

readonly class CreateTagRequestDto
{
    public function __construct(
        public string $alias,
        public string $name,
        public bool $active,
    ) {}
}
