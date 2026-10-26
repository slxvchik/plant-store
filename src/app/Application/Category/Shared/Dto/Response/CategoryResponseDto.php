<?php

declare(strict_types=1);

namespace App\Application\Category\Shared\Dto\Response;

use App\Domain\Category\Model\Category;
use JsonSerializable;
use Override;

readonly class CategoryResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public ?CategoryResponseDto $parent,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active,
    ) {}

    public static function fromDomain(Category $category, ?Category $parent): self
    {
        return new self(
            id: $category->id->value,
            parent: $parent !== null ? self::fromDomain($parent, null) : null,
            alias: $category->alias,
            sort: $category->sort,
            name: $category->name,
            active: $category->active,
        );
    }

    /**
     * @return array{id: string, parent: ?array<string, mixed>, alias: string, sort: int, name: string, active: bool}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'parent' => $this->parent?->jsonSerialize(),
            'alias' => $this->alias,
            'sort' => $this->sort,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}
