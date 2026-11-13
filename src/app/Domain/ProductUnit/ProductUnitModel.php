<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit;

use App\Domain\Product\Exception\ProductShipReserveException;
use App\Domain\ProductStatusHistory\ProductUnitStatusHistoryItemModel;
use App\Domain\Shared\Uuid\Uuid;
use DateTimeImmutable;

/**
 * Concrete plant in warehouse
 */
class ProductUnitModel
{
    public private(set) Uuid $id;

    public private(set) string $offerId;

    public private(set) string $warehouseId;

    public private(set) bool $reserved;

    public private(set) ?DateTimeImmutable $sowingDate;

    /**
     * @var ProductUnitStatusHistoryItemModel[]
     */
    public private(set) array $statusHistory;

    public private(set) string $productUnitStatusId;

    /**
     * @var string json data with comments
     */
    public private(set) string $comments;

    public function __construct(
    ) {}

    public function reserve(): void
    {
        $this->reserved = true;
    }

    public function cancelReserve(int $quantity): void
    {
        $this->reserved = false;
    }

    /**
     * @throws ProductShipReserveException
     */
    public function ship(int $quantity): self
    {
        $reservedQuantity = $this->reserved - $quantity;
        if ($reservedQuantity < 0) {
            throw new ProductShipReserveException;
        }

        return new self(
            $this->warehouseId,
            $this->quantity,
            $reservedQuantity
        );
    }

    public function refund(int $quantity): self
    {
        return new self(
            $this->warehouseId,
            $this->quantity + $quantity,
            $this->reserved
        );
    }
}
