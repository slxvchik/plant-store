<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\Shared\Dto\Response;

use App\Domain\ProductSupply\ProductSupplyModel;
use DateTimeInterface;
use JsonSerializable;
use Override;

readonly class ProductSupplyResponseDto implements JsonSerializable
{
    /**
     * @param  string[]  $productUnitIds
     */
    public function __construct(
        public string $id,
        public ?string $supplierId,
        public ?string $offerId,
        public array $productUnitIds,
        public int $declaredQuantity,
        public int $actualQuantity,
        public ?int $unitPurchasePriceInKopecks,
        public ?int $totalPurchasePriceInKopecks,
        public string $comment,
        public bool $misGraded,
        public string $createdAt,
        public ?string $updatedAt,
    ) {}

    public static function fromDomain(ProductSupplyModel $productSupply): self
    {
        return new self(
            id: $productSupply->id->value,
            supplierId: $productSupply->supplierId,
            offerId: $productSupply->offerId,
            productUnitIds: $productSupply->productUnitIds,
            declaredQuantity: $productSupply->declaredQuantity,
            actualQuantity: $productSupply->actualQuantity,
            unitPurchasePriceInKopecks: $productSupply->unitPurchasePriceInKopecks,
            totalPurchasePriceInKopecks: $productSupply->totalPurchasePriceInKopecks,
            comment: $productSupply->comment,
            misGraded: $productSupply->misGraded,
            createdAt: $productSupply->createdAt->format(DateTimeInterface::ATOM),
            updatedAt: $productSupply->updatedAt?->format(DateTimeInterface::ATOM),
        );
    }

    /**
     * @return array{id: string, supplierId: ?string, offerId: ?string, productUnitIds: string[], declaredQuantity: int, actualQuantity: int, unitPurchasePriceInKopecks: ?int, totalPurchasePriceInKopecks: ?int, comment: string, misGraded: bool, createdAt: string, updatedAt: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'offerId' => $this->offerId,
            'productUnitIds' => $this->productUnitIds,
            'declaredQuantity' => $this->declaredQuantity,
            'actualQuantity' => $this->actualQuantity,
            'unitPurchasePriceInKopecks' => $this->unitPurchasePriceInKopecks,
            'totalPurchasePriceInKopecks' => $this->totalPurchasePriceInKopecks,
            'comment' => $this->comment,
            'misGraded' => $this->misGraded,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
