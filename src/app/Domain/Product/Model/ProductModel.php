<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Product\Exception\OfferNotFoundException;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class ProductModel
{
    final public private(set) Uuid $id;

    public private(set) bool $active;

    public private(set) string $alias {
        /**
         * @throws InternalException
         */
        set {
            if (empty($value)) {
                throw new InternalException('Alias');
            }
            $this->alias = $value;
        }
    }

    public private(set) int $sort;

    public private(set) string $name {
        /**
         * @throws InternalException
         */
        set {
            if (empty($value)) {
                throw new InternalException('Alias');
            }
            $this->name = $value;
        }
    }

    public private(set) ?string $description;

    /**
     * @var OfferModel[]
     */
    private array $offers;

    /**
     * @var ?string Category id
     */
    public private(set) ?string $categoryId;

    /**
     * @var string[] Tag ids
     */
    public private(set) array $tagIds;

    /**
     * @var SortedItem<string>[] sorted Video ids
     */
    public private(set) array $videoIds;

    /**
     * @var SortedItem<string>[] sorted Image ids
     */
    public private(set) array $imageIds;

    /**
     * @var bool displayed on main page
     */
    public private(set) bool $featured;

    /**
     * @param  string[]  $tags
     * @param  SortedItem<string>[]  $videoIds
     * @param  SortedItem<string>[]  $imageIds
     * @param  OfferModel[]  $offers
     */
    private function __construct(Uuid $id, bool $active, string $alias, int $sort, string $name, ?string $description, ?string $categoryId, array $tags, array $videoIds, array $imageIds, array $offers, bool $featured = false)
    {
        $this->id = $id;
        $this->active = $active;
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->tagIds = $tags;
        $this->videoIds = $videoIds;
        $this->imageIds = $imageIds;
        $this->offers = $offers;
        $this->featured = $featured;
    }

    /**
     * @param  string[]  $tags
     * @param  SortedItem<string>[]  $videoIds
     * @param  SortedItem<string>[]  $imageIds
     * @param  OfferModel[]  $offers
     */
    public static function fromDb(string $id, bool $active, string $alias, int $sort, string $name, ?string $description, ?string $categoryId, array $tags, array $videoIds, array $imageIds, array $offers, bool $featured): self
    {
        $uuid = new Uuid($id);

        return new self(
            id: $uuid,
            active: $active,
            alias: $alias,
            sort: $sort,
            name: $name,
            description: $description,
            categoryId: $categoryId,
            tags: $tags,
            videoIds: $videoIds,
            imageIds: $imageIds,
            offers: $offers,
            featured: $featured,
        );
    }

    /**
     * @param  string[]  $tags
     * @param  SortedItem<string>[]  $videoIds
     * @param  SortedItem<string>[]  $imageIds
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $alias, int $sort, string $name, ?string $categoryId, array $tags, array $videoIds, array $imageIds, ?string $description, bool $featured): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $newUuid = new Uuid($uuidValue);

        return new self(
            id: $newUuid,
            active: $active,
            alias: $alias,
            sort: $sort,
            name: $name,
            description: $description,
            categoryId: $categoryId,
            tags: $tags,
            videoIds: $videoIds,
            imageIds: $imageIds,
            offers: [],
            featured: $featured,
        );
    }

    /**
     * @param  string[]  $tagIds
     * @param  SortedItem<string>[]  $videoIds
     * @param  SortedItem<string>[]  $imageIds
     */
    public function update(string $alias, int $sort, string $name, bool $active, ?string $description, ?string $categoryId, array $tagIds, array $videoIds, array $imageIds, bool $featured): void
    {
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->tagIds = $tagIds;
        $this->videoIds = $videoIds;
        $this->imageIds = $imageIds;
        $this->featured = $featured;
    }

    /**
     * @param  SaveOffer[]  $saveOffers
     *
     * @throws OfferNotFoundException
     */
    public function saveOffers(array $saveOffers, UuidGeneratorInterface $uuidGeneratorInterface): void
    {
        $actualOfferIds = [];
        foreach ($saveOffers as $saveOffer) {
            $id = $saveOffer->id;

            if ($id === null) {
                $newOffer = OfferModel::createNew(
                    uuidIdentityGenerator: $uuidGeneratorInterface,
                    active: $saveOffer->active,
                    sku: $saveOffer->sku,
                    name: $saveOffer->name,
                    sort: $saveOffer->sort,
                    description: $saveOffer->description,
                    price: $saveOffer->price,
                    stockQuantity: $saveOffer->stockQuantity,
                    imageIds: $saveOffer->imageIds,
                    videoIds: $saveOffer->videoIds
                );
                $this->offers[$newOffer->id->value] = $newOffer;
                $actualOfferIds[] = $newOffer->id->value;

                continue;
            }

            if (! isset($this->offers[$id])) {
                throw new OfferNotFoundException;
            }

            $this->offers[$id]->update(
                active: $saveOffer->active,
                sku: $saveOffer->sku,
                name: $saveOffer->name,
                sort: $saveOffer->sort,
                description: $saveOffer->description,
                price: $saveOffer->price,
                stockQuantity: $saveOffer->stockQuantity,
                imageIds: $saveOffer->imageIds,
                videoIds: $saveOffer->videoIds
            );
            $actualOfferIds[] = $id;
        }

        $idsToDelete = array_diff(array_keys($this->offers), $actualOfferIds);

        foreach ($idsToDelete as $idToDelete) {
            unset($this->offers[$idToDelete]);
        }
    }

    /**
     * @return OfferModel[]
     */
    public function getOffers(): array
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer;
        }

        return $offers;
    }

    /**
     * @throws OfferNotFoundException
     */
    public function getOffer(string $offerId): OfferModel
    {
        if (! $this->offerExists($offerId)) {
            throw new OfferNotFoundException;
        }

        return $this->offers[$offerId];
    }

    public function offerExists(string $offerId): bool
    {
        return isset($this->offers[$offerId]);
    }
}
