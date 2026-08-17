<?php

declare(strict_types=1);

namespace App\Domain\Product\Models;

use App\Domain\Product\Exceptions\ProductFastSellQuantityException;
use App\Domain\Product\Exceptions\ProductQuantityRemoveReserveException;
use App\Domain\Product\Exceptions\ProductQuantityReserveException;
use App\Domain\Product\Exceptions\ProductShipReserveException;
use App\Domain\Product\Exceptions\ProductSkuSetPriceException;
use App\Domain\Product\Exceptions\ProductSkuSetQuantityException;
use App\Domain\Product\Exceptions\ProductSkuSetReservedException;
use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class ProductSku
{
    private(set) Uuid $id;
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
    private(set) int $quantity {
        set {
            if ($value <= 0) {
                throw new ProductSkuSetQuantityException();
            }
            $this->quantity = $value;
        }
    }
    private(set) int $reserved {
        set {
            if ($value <= 0) {
                throw new ProductSkuSetReservedException();
            }
            $this->reserved = $value;
        }
    }
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

    private function __construct(Uuid $id, bool $active, string $sku, ?string $description, int $price, int $quantity, int $reserved, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate)
    {
        $this->id = $id;
        $this->active = $active;
        $this->sku = $sku;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->reserved = $reserved;
        $this->formFactor = $formFactor;
        $this->size = $size;
        $this->age = $age;
        $this->sowingDate = $sowingDate;
    }

    public static function fromDb(string $id, bool $active, string $sku, ?string $description, int $price, int $quantity, int $reserved, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            active: $active,
            sku: $sku,
            description: $description,
            price: $price,
            quantity: $quantity,
            reserved: $reserved,
            formFactor: $formFactor,
            size: $size,
            age: $age,
            sowingDate: $sowingDate
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator,  bool $active, string $sku, ?string $description, int $price, int $quantity, int $reserved, ?string $formFactor, ?string $size, ?int $age, ?DateTimeImmutable $sowingDate): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $newUuid = new Uuid($uuidValue);
        return new self(
            id: $newUuid,
            active: $active,
            sku: $sku,
            description: $description,
            price: $price,
            quantity: $quantity,
            reserved: $reserved,
            formFactor: $formFactor,
            size: $size,
            age: $age,
            sowingDate: $sowingDate
        );
    }

    public function reserve(int $quantity): void
    {
        $stockQuantity = $this->quantity - $quantity;
        if ($stockQuantity < 0) {
            throw new ProductQuantityReserveException();
        }
        $this->quantity = $stockQuantity;
        $this->reserved += $quantity;
    }

    public function cancelReserve(int $quantity): void
    {
        $reserved = $this->reserved - $quantity;
        if ($reserved < 0) {
            throw new ProductQuantityRemoveReserveException();
        }
        $this->quantity += $reserved;
        $this->reserved = $reserved;
    }

    public function ship(int $quantity): void
    {
        $reservedQuantity = $this->reserved - $quantity;
        if ($reservedQuantity < 0) {
            throw new ProductShipReserveException();
        }
        $this->reserved = $reservedQuantity;
    }

    public function refund(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function fastSell(int $quantity): void
    {
        $stockQuantity = $this->quantity - $quantity;
        if ($stockQuantity < 0) {
            throw new ProductFastSellQuantityException();
        }
        $this->quantity = $stockQuantity;
    }
}
