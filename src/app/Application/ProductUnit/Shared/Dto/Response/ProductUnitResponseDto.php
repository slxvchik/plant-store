<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\Shared\Dto\Response;

use App\Domain\ProductUnit\ProductUnitModel;
use DateTimeInterface;
use JsonSerializable;
use Override;

readonly class ProductUnitResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public ?string $productSupplyId,
        public ?string $offerId,
        public string $warehouseId,
        public bool $reserved,
        public ?string $sowingDate,
        public string $productUnitStatusId,
        public string $comments,
        public ?string $qrCode,
        public ?string $barcode,
    ) {}

    public static function fromDomain(ProductUnitModel $productUnit): self
    {
        return new self(
            id: $productUnit->id->value,
            productSupplyId: $productUnit->productSupplyId,
            offerId: $productUnit->offerId,
            warehouseId: $productUnit->warehouseId,
            reserved: $productUnit->reserved,
            sowingDate: $productUnit->sowingDate?->format(DateTimeInterface::ATOM),
            productUnitStatusId: $productUnit->productUnitStatusId,
            comments: $productUnit->comments,
            qrCode: $productUnit->qrCode,
        );
    }

    /**
     * @return array{id: string, productSupplyId: ?string, offerId: ?string, warehouseId: string, reserved: bool, sowingDate: ?string, productUnitStatusId: string, comments: string, qrCode: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'productSupplyId' => $this->productSupplyId,
            'offerId' => $this->offerId,
            'warehouseId' => $this->warehouseId,
            'reserved' => $this->reserved,
            'sowingDate' => $this->sowingDate,
            'productUnitStatusId' => $this->productUnitStatusId,
            'comments' => $this->comments,
            'qrCode' => $this->qrCode,
        ];
    }
}
