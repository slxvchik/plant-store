<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit;

use App\Domain\ProductUnitStatus\Model\ProductUnitStatusHistoryItemModel;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class ProductUnitModel
{
    public private(set) Uuid $id;

    public private(set) ?string $productSupplyId;

    public private(set) ?string $offerId;

    public private(set) string $warehouseId;

    public private(set) bool $reserved;

    public private(set) ?DateTimeImmutable $sowingDate;

    /**
     * @var ProductUnitStatusHistoryItemModel[]
     */
    public private(set) array $statusHistory;

    public private(set) string $productUnitStatusId;

    public private(set) string $comments;

    /**
     * @param  ProductUnitStatusHistoryItemModel[]  $statusHistory
     */
    private function __construct(
        Uuid $id,
        ?string $productSupplyId,
        ?string $offerId,
        string $warehouseId,
        bool $reserved,
        ?DateTimeImmutable $sowingDate,
        array $statusHistory,
        string $productUnitStatusId,
        string $comments,
    ) {
        $this->id = $id;
        $this->productSupplyId = $productSupplyId;
        $this->offerId = $offerId;
        $this->warehouseId = $warehouseId;
        $this->reserved = $reserved;
        $this->sowingDate = $sowingDate;
        $this->statusHistory = $statusHistory;
        $this->productUnitStatusId = $productUnitStatusId;
        $this->comments = $comments;
    }

    public static function createNew(
        UuidGeneratorInterface $uuidGenerator,
        ?string $productSupplyId,
        ?string $offerId,
        string $warehouseId,
        string $productUnitStatusId,
        bool $reserved = false,
        ?DateTimeImmutable $sowingDate = null,
        string $comments = '',
    ): self {
        return new self(
            id: new Uuid($uuidGenerator->generate()),
            productSupplyId: $productSupplyId,
            offerId: $offerId,
            warehouseId: $warehouseId,
            reserved: $reserved,
            sowingDate: $sowingDate,
            statusHistory: [],
            productUnitStatusId: $productUnitStatusId,
            comments: $comments,
        );
    }

    /**
     * @param  ProductUnitStatusHistoryItemModel[]  $statusHistory
     */
    public static function fromDb(
        string $id,
        ?string $productSupplyId,
        ?string $offerId,
        string $warehouseId,
        bool $reserved,
        ?DateTimeImmutable $sowingDate,
        array $statusHistory,
        string $productUnitStatusId,
        string $comments,
    ): self {
        return new self(
            id: new Uuid($id),
            productSupplyId: $productSupplyId,
            offerId: $offerId,
            warehouseId: $warehouseId,
            reserved: $reserved,
            sowingDate: $sowingDate,
            statusHistory: $statusHistory,
            productUnitStatusId: $productUnitStatusId,
            comments: $comments,
        );
    }

    public function update(
        ?string $productSupplyId,
        ?string $offerId,
        string $warehouseId,
        bool $reserved,
        ?DateTimeImmutable $sowingDate,
        string $productUnitStatusId,
        string $comments,
    ): void {
        $this->productSupplyId = $productSupplyId;
        $this->offerId = $offerId;
        $this->warehouseId = $warehouseId;
        $this->reserved = $reserved;
        $this->sowingDate = $sowingDate;
        $this->productUnitStatusId = $productUnitStatusId;
        $this->comments = $comments;
    }

    public function reserve(): void
    {
        $this->reserved = true;
    }

    public function cancelReserve(): void
    {
        $this->reserved = false;
    }
}
