<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Product
{
    private(set) final Uuid $id;
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
     * @var Offer[]
     */
    private(set) array $offers;
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

    /**
     * @param string[] $categories
     * @param string[] $tags
     * @param string[] $videoIds
     * @param string[] $imageIds
     * @param Offer[] $offers
     */
    private function __construct(Uuid $id, bool $active, string $alias, string $name, ?string $description, array $categories, array $tags, array $videoIds, array $imageIds, array $offers = [])
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
        $this->offers = $offers;
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

    /**
     * @param string[] $categories
     * @param string[] $tags
     * @param string[] $videoIds
     * @param string[] $imageIds
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $alias, string $name, array $categories = [], array $tags = [], array $videoIds = [], array $imageIds = [], ?string $description = null): self
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

    /**
     * @param string[] $categoryIds
     * @param string[] $tagIds
     * @param string[] $videoIds
     * @param string[] $imageIds
     */
    public function update(string $alias, string $name, bool $active, ?string $description, array $categoryIds, array $tagIds, array $videoIds, array $imageIds): void
    {
        $this->alias = $alias;
        $this->name = $name;
        $this->active = $active;
        $this->description = $description;
        $this->categoryIds = $categoryIds;
        $this->tagIds = $tagIds;
        $this->videoIds = $videoIds;
        $this->imageIds = $imageIds;
    }

    /**
     * @param Offer[] $offers
     */
    public function updateOffers(array $offers): void
    {
        $newOfferIds = [];
        foreach ($offers as $newOffer) {
            $id = $newOffer->id->value;

            if (!$id) {
                continue;
            }

            $newOfferIds[] = $id;

            if (!isset($this->offers[$id])) {
                $this->offers[$id] = $newOffer;
                continue;
            }

            $this->offers[$id]->update(
                active: $newOffer->active,
                sku: $newOffer->sku,
                description: $newOffer->description,
                price: $newOffer->price,
                stocks: $newOffer->stocks,
                formFactor: $newOffer->formFactor,
                size: $newOffer->size,
                age: $newOffer->age,
                sowingDate: $newOffer->sowingDate
            );
        }

        $idsToDelete = array_diff(array_keys($this->offers), $newOfferIds);

        foreach ($idsToDelete as $idToDelete) {
            unset($this->offers[$idToDelete]);
        }
    }
}
