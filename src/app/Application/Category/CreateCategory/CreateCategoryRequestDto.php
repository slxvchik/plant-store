<?php

declare(strict_types=1);

namespace App\Application\Category\CreateCategory;

readonly class CreateCategoryRequestDto
{
    public function __construct(
        public ?string $parentId,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active
    ) {}
}
