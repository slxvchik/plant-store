<?php

declare(strict_types=1);

namespace App\Application\News\Shared\Dto\Response;

use App\Domain\News\Model\News;
use JsonSerializable;
use Override;

readonly class NewsResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $alias,
        public int $sort,
        public string $name,
        public bool $active,
        public ?string $description,
    ) {}

    public static function fromDomain(News $news): self
    {
        return new self(
            id: $news->id->value,
            alias: $news->alias,
            sort: $news->sort,
            name: $news->name,
            active: $news->active,
            description: $news->description,
        );
    }

    /**
     * @return array{id: string, alias: string, sort: int, name: string, active: bool, description: ?string}
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
            'description' => $this->description,
        ];
    }
}
