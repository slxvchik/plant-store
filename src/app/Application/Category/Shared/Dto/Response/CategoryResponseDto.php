<?php

declare(strict_types=1);

namespace App\Application\Category\Shared\Dto\Response;

use App\Domain\Category\Model\Category;

readonly class CategoryResponseDto
{
    public function __construct(
        public string $id,
        public ?CategoryResponseDto $parent,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active
    ) {}

    public static function fromDomain(Category $category, ?Category $parent): self
    {
        return new self(
            id: $category->id->value,
            parent: $parent !== null ? self::fromDomain(
                category: $parent,
                parent: null,
            ) : null,
            alias: $category->alias,
            sort: $category->sort,
            name: $category->name,
            active: $category->active
        );
    }
}
