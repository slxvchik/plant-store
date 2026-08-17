<?php

declare(strict_types=1);

namespace App\Domain\Product\Models;

use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Product
{
    private(set) Uuid $id;
    private(set) bool $active;
    private(set) string $alias {
        set {
            if (empty($value)) {
                throw new FieldRequiredException("Alias");
            }
            $this->alias = $value;
        }
    }
    private(set) string $name {
        set {
            if (empty($value)) {
                throw new FieldRequiredException("Alias");
            }
            $this->name = $value;
        }
    }
    private(set) ?string $description;
    /**
     * @var string[] Category ids
     */
    private(set) array $categoryIds;
    /**
     * @var string[] Tag ids
     */

    private(set) array $tagIds;
    /**
     * @var string[] Video ids
     */
    private(set) array $videoIds;
    /**
     * @var string[] Image ids
     */
    private(set) array $imageIds;

    private function __construct(Uuid $id, bool $active, string $alias, string $name, ?string $description, array $categories, array $tags, array $videoIds, array $imageIds)
    {
        $this->id = $id;
        $this->active = $active;
        $this->alias = $alias;
        $this->name = $name;
        $this->description = $description;
        $this->categoryIds = $categories;
        $this->tagIds = $tags;
        $this->videoIds = $videoIds;
        $this->imageIds = $imageIds;
    }

    public static function fromDb(string $id, bool $active, string $alias, string $name, ?string $description, array $categories, array $tags, array $videoIds, array $imageIds): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            active: $active,
            alias: $alias,
            name: $name,
            description: $description,
            categories: $categories,
            tags: $tags,
            videoIds: $videoIds,
            imageIds: $imageIds
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $alias, string $name, int $price, int $quantity, array $categories = [], array $tags = [], array $videoIds = [], array $imageIds = [], ?string $description = null): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $newUuid = new Uuid($uuidValue);
        return new self(
            id: $newUuid,
            active: $active,
            alias: $alias,
            name: $name,
            description: $description,
            categories: $categories,
            tags: $tags,
            videoIds: $videoIds,
            imageIds: $imageIds
        );
    }

    public function update(string $alias, string $name, bool $active, ?string $description, int $price, int $quantity, $reserved, array $categories, array $tags, array $videoIds, array $imageIds): void
    {
        $this->alias = $alias;
        $this->name = $name;
        $this->active = $active;
        $this->description = $description;
        $this->categoryIds = $categories;
        $this->tagIds = $tags;
        $this->videoIds = $videoIds;
        $this->imageIds = $imageIds;
    }
}
