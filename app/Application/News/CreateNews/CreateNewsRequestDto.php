<?php

declare(strict_types=1);

namespace App\Application\News\CreateNews;

readonly class CreateNewsRequestDto
{
    public function __construct(
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active,
        public ?string $description,
    ) {}
}
