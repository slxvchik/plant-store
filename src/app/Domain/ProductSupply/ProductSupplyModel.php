<?php

declare(strict_types=1);

namespace App\Domain\ProductSupply;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class ProductSupplyModel
{
    public private(set) Uuid $id;

    public private(set) ?string $supplierId;

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
    private function __construct(
        Uuid $id,
        ?string $supplierId,
        ?string $offerId,
        array $productUnitIds,
        int $declaredQuantity,
        int $actualQuantity,
        ?int $unitPurchasePriceInKopecks,
        ?int $totalPurchasePriceInKopecks,
        string $comment,
        bool $misGraded,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt,
    ) {
        $this->id = $id;
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
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param  string[]  $productUnitIds
     */
    public static function createNew(
        UuidGeneratorInterface $uuidGenerator,
        string $supplierId,
        ?string $offerId,
        array $productUnitIds,
        int $declaredQuantity,
        int $actualQuantity,
        ?int $unitPurchasePriceInKopecks,
        ?int $totalPurchasePriceInKopecks,
        string $comment,
        bool $misGraded,
    ): self {
        return new self(
            id: new Uuid($uuidGenerator->generate()),
            supplierId: $supplierId,
            offerId: $offerId,
            productUnitIds: $productUnitIds,
            declaredQuantity: $declaredQuantity,
            actualQuantity: $actualQuantity,
            unitPurchasePriceInKopecks: $unitPurchasePriceInKopecks,
            totalPurchasePriceInKopecks: $totalPurchasePriceInKopecks,
            comment: $comment,
            misGraded: $misGraded,
            createdAt: new DateTimeImmutable,
            updatedAt: null,
        );
    }

    /**
     * @param  string[]  $productUnitIds
     */
    public static function fromDb(
        string $id,
        ?string $supplierId,
        ?string $offerId,
        array $productUnitIds,
        int $declaredQuantity,
        int $actualQuantity,
        ?int $unitPurchasePriceInKopecks,
        ?int $totalPurchasePriceInKopecks,
        string $comment,
        bool $misGraded,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: new Uuid($id),
            supplierId: $supplierId,
            offerId: $offerId,
            productUnitIds: $productUnitIds,
            declaredQuantity: $declaredQuantity,
            actualQuantity: $actualQuantity,
            unitPurchasePriceInKopecks: $unitPurchasePriceInKopecks,
            totalPurchasePriceInKopecks: $totalPurchasePriceInKopecks,
            comment: $comment,
            misGraded: $misGraded,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public function update(
        string $supplierId,
        ?string $offerId,
        int $declaredQuantity,
        int $actualQuantity,
        ?int $unitPurchasePriceInKopecks,
        ?int $totalPurchasePriceInKopecks,
        string $comment,
        bool $misGraded,
    ): void {
        $this->supplierId = $supplierId;
        $this->offerId = $offerId;
        $this->declaredQuantity = $declaredQuantity;
        $this->actualQuantity = $actualQuantity;
        $this->unitPurchasePriceInKopecks = $unitPurchasePriceInKopecks;
        $this->totalPurchasePriceInKopecks = $totalPurchasePriceInKopecks;
        $this->comment = $comment;
        $this->misGraded = $misGraded;
        $this->updatedAt = new DateTimeImmutable;
    }
}
