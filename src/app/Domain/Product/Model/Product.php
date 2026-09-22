<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Product\Exception\OfferNotFoundException;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Product
{
    private(set) final Uuid $id;
    private(set) bool $active;
    private(set) string $alias {
        set {
            if (empty($value)) {
                throw new InternalException("Alias");
            }
            $this->alias = $value;
        }
    }
    private(set) string $name {
        set {
            if (empty($value)) {
                throw new InternalException("Alias");
            }
            $this->name = $value;
        }
    }
    private(set) ?string $description;
    /**
     * @var Offer[]
     */
    private array $offers;
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
    private function __construct(Uuid $id, bool $active, string $alias, string $name, ?string $description, array $categories, array $tags, array $videoIds, array $imageIds, array $offers)
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

    public static function fromDb(string $id, bool $active, string $alias, string $name, ?string $description, array $categories, array $tags, array $videoIds, array $imageIds, array $offers): self
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
            imageIds: $imageIds,
            offers: $offers
        );
    }

    /**
     * @param string[] $categories
     * @param string[] $tags
     * @param string[] $videoIds
     * @param string[] $imageIds
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $alias, string $name, array $categories, array $tags, array $videoIds, array $imageIds, ?string $description): self
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
            imageIds: $imageIds,
            offers: []
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
     * @param SaveOffer[] $saveOffers
     */
    public function saveOffers(array $saveOffers, UuidGeneratorInterface $uuidGeneratorInterface): void
    {
        $newOfferIds = [];
        foreach ($saveOffers as $saveOffer) {
            $id = $saveOffer->id;

            if ($id === null) {
                $newOffer = Offer::createNew(
                    uuidIdentityGenerator: $uuidGeneratorInterface,
                    active: $saveOffer->active,
                    sku: $saveOffer->sku,
                    description: $saveOffer->description,
                    price: $saveOffer->price,
                    stocks: $saveOffer->stocks,
                    formFactor: $saveOffer->formFactor,
                    size: $saveOffer->size,
                    age: $saveOffer->age,
                    sowingDate: $saveOffer->sowingDate
                );
                $this->offers[$newOffer->id->value] = $saveOffer;
                $newOfferIds[] = $newOffer->id->value;
                continue;
            }


            if (!isset($this->offers[$id])) {
                throw new OfferNotFoundException();
            }

            $this->offers[$id]->update(
                active: $saveOffer->active,
                sku: $saveOffer->sku,
                description: $saveOffer->description,
                price: $saveOffer->price,
                stocks: $saveOffer->stocks,
                formFactor: $saveOffer->formFactor,
                size: $saveOffer->size,
                age: $saveOffer->age,
                sowingDate: $saveOffer->sowingDate
            );
        }

        $idsToDelete = array_diff(array_keys($this->offers), $newOfferIds);

        foreach ($idsToDelete as $idToDelete) {
            unset($this->offers[$idToDelete]);
        }
    }

    /**
     * @return Offer[]
     */
    public function getOffers(): array
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer;
        }
        return $offers;
    }

    public function getOffer(string $offerId): Offer
    {
        if (!$this->offerExists($offerId)) {
            throw new OfferNotFoundException();
        }
        return $this->offers[$offerId];
    }

    public function offerExists(string $offerId): bool
    {
        return $this->offers[$offerId] !== null;
    }

    public function getOfferAvailableQuantity(string $offerId): int
    {
        $availableCount = 0;
        $offer = $this->getOffer($offerId);
        foreach ($offer->stocks as $stock) {
            $availableCount += $stock->getAvailableQuantity();
        }
        return $availableCount;
    }
}
