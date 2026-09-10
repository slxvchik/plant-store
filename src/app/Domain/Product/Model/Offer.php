<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Product\Exception\ProductSkuSetPriceException;
use App\Domain\Product\Exception\ProductStockNotFoundException;
use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

/**
 * Aggregate of Product
 */
class Offer
{
    private(set) final Uuid $id;
    private(set) bool $active;
    private(set) string $sku {
        set {
            if (empty($value)) {
                throw new FieldRequiredException("Sku");
            }
            $this->sku = $value;
        }
    }
    private(set) ?string $description;
    /**
     * @var int $price in kopecks
     * Example (100.10 rub: $price = 10010)
     */
    private(set) int $price {
        set {
            if ($value <= 0) {
                throw new ProductSkuSetPriceException();
            }
            $this->price = $value;
        }
    }
    /**
     * @var Stock[] stocks map
     * [warehouseId => Stock]
     */
    private(set) array $stocks;
    /**
     * @var string|null Seeds | Seedlings | Seedling
     */
    private(set) ?string $formFactor;
    private(set) ?string $size;
    /**
     * @var int|null Age in months
     */
    private(set) ?int $age;
    private(set) ?DateTimeImmutable $sowingDate;

    /**
     * @param Stock[] $stocks
     */
    public function __construct(string $id, bool $active, string $sku, ?string $description, int $price, array $stocks, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate)
    {
        $uuid = new Uuid($id);
        $this->id = $uuid;
        $this->active = $active;
        $this->sku = $sku;
        $this->description = $description;
        $this->price = $price;
        $this->stocks = $stocks;
        $this->formFactor = $formFactor;
        $this->size = $size;
        $this->age = $age;
        $this->sowingDate = $sowingDate;
    }

    /**
     * @param Stock[] $stocks
     */
    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator,  bool $active, string $sku, ?string $description, int $price, array $stocks, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate): self
    {
        $uuid = $uuidIdentityGenerator->generate();
        return new self(
            id: $uuid,
            active: $active,
            sku: $sku,
            description: $description,
            price: $price,
            stocks: $stocks,
            formFactor: $formFactor,
            size: $size,
            age: $age,
            sowingDate: $sowingDate
        );
    }

    /**
     * @param Stock[] $stocks
     */
    public function update(
        bool $active,
        string $sku,
        ?string $description,
        int $price,
        array $stocks,
        ?string $formFactor,
        ?string $size,
        ?int $age,
        ?DateTimeImmutable $sowingDate,
    ): void {
        $this->active = $active;
        $this->sku = $sku;
        $this->description = $description;
        $this->price = $price;
        $this->stocks = $stocks;
        $this->formFactor = $formFactor;
        $this->size = $size;
        $this->age = $age;
        $this->sowingDate = $sowingDate;
    }

    public function reserve(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->reserve($quantity);
    }

    public function cancelReserve(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->cancelReserve($quantity);
    }

    public function ship(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->ship($quantity);
    }

    public function refund(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->refund($quantity);
    }

    public function fastSell(string $warehouseId, int $quantity): void
    {
        $stock = $this->getStockByWarehouseId($warehouseId);
        $this->stocks[$warehouseId] = $stock->fastSell($quantity);
    }

    private function getStockByWarehouseId(string $warehouseId): Stock
    {
        $stock = $this->stocks[$warehouseId] ?? null;

        if ($stock === null) {
            throw new ProductStockNotFoundException();
        }

        return $stock;
    }
}
