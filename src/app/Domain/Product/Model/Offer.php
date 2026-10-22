<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Product\Exception\ProductQuantityRemoveReserveException;
use App\Domain\Product\Exception\ProductQuantityReserveException;
use App\Domain\Product\Exception\ProductShipReserveException;
use App\Domain\Product\Exception\ProductSkuSetPriceException;
use App\Domain\Product\Exception\ProductStockNotFoundException;
use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

/**
 * Aggregate of Product
 */
class Offer
{
    final public private(set) Uuid $id;

    public private(set) bool $active;

    public private(set) string $sku {
        /**
         * @throws InternalException
         */
        set {
            if (empty($value)) {
                throw new InternalException('Sku');
            }
            $this->sku = $value;
        }
    }

    public private(set) int $sort;

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
     * @var Stock[] stocks map
     *              [warehouseId => Stock]
     */
    public private(set) array $stocks;

    /**
     * @var string|null Seeds | Seedlings | Seedling
     */
    public private(set) ?string $formFactor;

    public private(set) ?string $size;

    /**
     * @var int|null Age in months
     */
    public private(set) ?int $age;

    public private(set) ?DateTimeImmutable $sowingDate;

    /**
     * @var SortedItem<string>[] sorted Image ids
     */
    public private(set) array $imageIds;

    /**
     * @var SortedItem<string>[] sorted Video ids
     */
    public private(set) array $videoIds;

    /**
     * @param  Stock[]  $stocks
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public function __construct(string $id, bool $active, string $sku, int $sort, ?string $description, int $price, array $stocks, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate, array $imageIds, array $videoIds)
    {
        $uuid = new Uuid($id);
        $this->id = $uuid;
        $this->active = $active;
        $this->sku = $sku;
        $this->sort = $sort;
        $this->description = $description;
        $this->price = $price;
        $this->stocks = $stocks;
        $this->formFactor = $formFactor;
        $this->size = $size;
        $this->age = $age;
        $this->sowingDate = $sowingDate;
        $this->imageIds = $imageIds;
        $this->videoIds = $videoIds;
    }

    /**
     * @param  Stock[]  $stocks
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, bool $active, string $sku, int $sort, ?string $description, int $price, array $stocks, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate, array $imageIds, array $videoIds): self
    {
        $uuid = $uuidIdentityGenerator->generate();

        return new self(
            id: $uuid,
            active: $active,
            sku: $sku,
            sort: $sort,
            description: $description,
            price: $price,
            stocks: $stocks,
            formFactor: $formFactor,
            size: $size,
            age: $age,
            sowingDate: $sowingDate,
            imageIds: $imageIds,
            videoIds: $videoIds
        );
    }

    /**
     * @param  Stock[]  $stocks
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public function update(
        bool $active,
        string $sku,
        int $sort,
        ?string $description,
        int $price,
        array $stocks,
        ?string $formFactor,
        ?string $size,
        ?int $age,
        ?DateTimeImmutable $sowingDate,
        array $imageIds,
        array $videoIds
    ): void {
        $this->active = $active;
        $this->sku = $sku;
        $this->sort = $sort;
        $this->description = $description;
        $this->price = $price;
        $this->stocks = $stocks;
        $this->formFactor = $formFactor;
        $this->size = $size;
        $this->age = $age;
        $this->sowingDate = $sowingDate;
        $this->imageIds = $imageIds;
        $this->videoIds = $videoIds;
    }

    /**
     * @throws ProductStockNotFoundException
     * @throws ProductQuantityReserveException
     */
    public function reserve(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->reserve($quantity);
    }

    /**
     * @throws ProductStockNotFoundException
     * @throws ProductQuantityRemoveReserveException
     */
    public function cancelReserve(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->cancelReserve($quantity);
    }

    /**
     * @throws ProductStockNotFoundException
     * @throws ProductShipReserveException
     */
    public function ship(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->ship($quantity);
    }

    /**
     * @throws ProductStockNotFoundException
     */
    public function refund(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->refund($quantity);
    }

    public function getAvailableQuantity(): int
    {
        $availableQuantity = 0;
        foreach ($this->stocks as $stock) {
            $availableQuantity += $stock->quantity;
        }

        return $availableQuantity;
    }

    /**
     * @throws ProductStockNotFoundException
     */
    private function getStockByWarehouseId(string $warehouseId): Stock
    {
        $stock = $this->stocks[$warehouseId] ?? null;

        if ($stock === null) {
            throw new ProductStockNotFoundException;
        }

        return $stock;
    }
}
