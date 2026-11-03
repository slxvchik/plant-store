<?php

declare(strict_types=1);

namespace App\Application\News\UpdateNews;

readonly class UpdateNewsRequestDto
{
    public function __construct(
        public string $id,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active,
        public ?string $description,
    ) {}
}
