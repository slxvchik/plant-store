<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Product\Exception\ProductSkuSetPriceException;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

/**
 * Product Configuration
 */
class OfferModel
{
    final public private(set) Uuid $id;

    public private(set) bool $active;

    public private(set) int $sort;

    public private(set) ?string $sku;

    public private(set) ?string $name;

    public private(set) ?string $description;

    /**
     * @var int in kopecks
     *          Example (100.10 rub: $price = 10010)
     */
    public private(set) int $price {
        /**
         * @throws ProductSkuSetPriceException
         */
        set {
            if ($value <= 0) {
                throw new ProductSkuSetPriceException;
            }
            $this->price = $value;
        }
    }

    /**
     * @var int in kopecks
     */
    public private(set) int $discountPrice {
        /**
         * @throws ProductSkuSetPriceException
         */
        set {
            if ($value <= 0) {
                throw new ProductSkuSetPriceException;
            }
            $this->discountPrice = $value;
        }
    }

    /**
     * @var int Aggregated data from available ProductUnit
     */
    public private(set) int $stockQuantity;

    /**
     * @var SortedItem<string>[] sorted Image ids
     */
    public private(set) array $imageIds;

    /**
     * @var SortedItem<string>[] sorted Video ids
     */
    public private(set) array $videoIds;

    /**
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public function __construct(string $id, bool $active, string $sku, ?string $name, int $sort, ?string $description, int $price, int $stockQuantity, array $imageIds, array $videoIds)
    {
        $uuid = new Uuid($id);
        $this->id = $uuid;
        $this->active = $active;
        $this->sku = $sku;
        $this->name = $name;
        $this->sort = $sort;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->imageIds = $imageIds;
        $this->videoIds = $videoIds;
    }

    /**
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $sku, ?string $name, int $sort, ?string $description, int $price, int $stockQuantity, array $imageIds, array $videoIds): self
    {
        $uuid = $uuidIdentityGenerator->generate();

        return new self(
            id: $uuid,
            active: $active,
            sku: $sku,
            name: $name,
            sort: $sort,
            description: $description,
            price: $price,
            stockQuantity: $stockQuantity,
            imageIds: $imageIds,
            videoIds: $videoIds
        );
    }

    /**
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public function update(
        bool $active,
        string $sku,
        ?string $name,
        int $sort,
        ?string $description,
        int $price,
        int $stockQuantity,
        array $imageIds,
        array $videoIds
    ): void {
        $this->active = $active;
        $this->sku = $sku;
        $this->name = $name;
        $this->sort = $sort;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->imageIds = $imageIds;
        $this->videoIds = $videoIds;
    }
}
