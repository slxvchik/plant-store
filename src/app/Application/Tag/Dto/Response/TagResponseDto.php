<?php

declare(strict_types=1);

namespace App\Application\Tag\Dto\Response;

use App\Domain\Tag\Model\Tag;

readonly class TagResponseDto
{
    public function __construct(
        public string $id,
        public string $alias,
        public string $name,
        public bool $active,
    ) {}

    public static function fromDomain(Tag $tag): self
    {
        return new self(
            id: $tag->id->value,
            alias: $tag->alias,
            name: $tag->name,
            active: $tag->active,
        );
    }
}
