<?php

declare(strict_types=1);

namespace App\Application\Category\Dto\Response;

use App\Domain\Category\Model\Category;

readonly class CategoryResponseDto
{
    public function __construct(
        public string $id,
        public string $alias,
        public string $name,
        public bool $active
    ) {}

    public static function fromDomain(Category $category): self
    {
        return new self(
            id: $category->id->value,
            alias: $category->alias,
            name: $category->name,
            active: $category->active
        );
    }
}
