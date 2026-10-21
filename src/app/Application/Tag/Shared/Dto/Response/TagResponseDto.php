<?php

declare(strict_types=1);

namespace App\Application\Tag\Shared\Dto\Response;

use App\Domain\Tag\Model\Tag;

readonly class TagResponseDto
{
    public function __construct(
        public string $id,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active,
    ) {}

    public static function fromDomain(Tag $tag): self
    {
        return new self(
            id: $tag->id->value,
            alias: $tag->alias,
            sort: $tag->sort,
            name: $tag->name,
            active: $tag->active,
        );
    }
}
