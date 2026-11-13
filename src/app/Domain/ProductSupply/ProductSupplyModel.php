<?php

namespace App\Domain\ProductSupply;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class ProductSupplyModel
{
    public private(set) Uuid $id;

    public private(set) string $supplierId;

    public private(set) ?string $offerId;

    /**
     * @var string[]
     */
    public private(set) array $productUnitIds;

    public private(set) int $declaredQuantity;

    public private(set) int $actualQuantity;

    public private(set) ?int $unitPurchasePriceInKopecks;

    public private(set) ?int $totalPurchasePriceInKopecks;

    public private(set) string $comment;

    public private(set) bool $misGraded;

    public private(set) DateTimeImmutable $createdAt;

    public private(set) ?DateTimeImmutable $updatedAt;

    /**
     * @param  string[]  $productUnitIds
     */
    private function __construct(string $id, string $supplierId, ?string $offerId, array $productUnitIds, int $declaredQuantity, int $actualQuantity, ?int $unitPurchasePriceInKopecks, ?int $totalPurchasePriceInKopecks, string $comment, bool $misGraded, DateTimeImmutable $createdAt)
    {
        $uuid = new Uuid($id);
        $this->id = $uuid;
        $this->supplierId = $supplierId;
        $this->offerId = $offerId;
        $this->productUnitIds = $productUnitIds;
        $this->declaredQuantity = $declaredQuantity;
        $this->actualQuantity = $actualQuantity;
        $this->unitPurchasePriceInKopecks = $unitPurchasePriceInKopecks;
        $this->totalPurchasePriceInKopecks = $totalPurchasePriceInKopecks;
        $this->comment = $comment;
        $this->misGraded = $misGraded;
        $this->createdAt = $createdAt;
    }

    public static function createNew(UuidGeneratorInterface $uuidGenerator, string $supplierId, ?string $offerId, array $productUnitIds, int $declaredQuantity, int $actualQuantity, ?int $unitPurchasePriceInKopecks, ?int $totalPurchasePriceInKopecks, string $comment, bool $misGraded): self
    {
        return new self(
            $uuidGenerator->generate(),
            $supplierId,
            $offerId,
            $productUnitIds,
            $declaredQuantity,
            $actualQuantity,
            $unitPurchasePriceInKopecks,
            $totalPurchasePriceInKopecks,
            $comment,
            $misGraded,
            new DateTimeImmutable,
        );
    }

    public static function fromDb(string $id, string $supplierId, ?string $offerId, array $productUnitIds, int $declaredQuantity, int $actualQuantity, ?int $unitPurchasePriceInKopecks, ?int $totalPurchasePriceInKopecks, string $comment, bool $misGraded, DateTimeImmutable $createdAt): self
    {
        return new self(
            $id,
            $supplierId,
            $offerId,
            $productUnitIds,
            $declaredQuantity,
            $actualQuantity,
            $unitPurchasePriceInKopecks,
            $totalPurchasePriceInKopecks,
            $comment,
            $misGraded,
            $createdAt,
        );
    }

    public function update(string $supplierId, ?string $offerId, array $productUnitIds, int $declaredQuantity, int $actualQuantity, ?int $unitPurchasePriceInKopecks, ?int $totalPurchasePriceInKopecks, string $comment, bool $misGraded): void
    {
        $this->supplierId = $supplierId;
        $this->offerId = $offerId;
        $this->productUnitIds = $productUnitIds;
        $this->declaredQuantity = $declaredQuantity;
        $this->actualQuantity = $actualQuantity;
        $this->unitPurchasePriceInKopecks = $unitPurchasePriceInKopecks;
        $this->totalPurchasePriceInKopecks = $totalPurchasePriceInKopecks;
        $this->comment = $comment;
        $this->misGraded = $misGraded;
    }
}
