<?php

declare(strict_types=1);

namespace App\Application\Tag\Shared\Dto\Response;

use App\Domain\Tag\Model\Tag;
use JsonSerializable;
use Override;

readonly class TagResponseDto implements JsonSerializable
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

    /**
     * @return array{id: string, alias: string, sort: int, name: string, active: bool}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'sort' => $this->sort,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}
