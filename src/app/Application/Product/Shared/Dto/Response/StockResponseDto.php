<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Application\Warehouse\Shared\Dto\Response\WarehouseResponseDto;
use App\Domain\Product\Model\Stock;
use JsonSerializable;
use Override;

readonly class StockResponseDto implements JsonSerializable
{
    public function __construct(
        public WarehouseResponseDto $warehouse,
        public int $quantity,
        public int $reserved,
    ) {}

    public static function fromDomain(Stock $stock, WarehouseResponseDto $warehouse): self
    {
        return new self(
            warehouse: $warehouse,
            quantity: $stock->quantity,
            reserved: $stock->reserved,
        );
    }

    /**
     * @return array{warehouse: WarehouseResponseDto, quantity: int, reserved: int}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'warehouse' => $this->warehouse,
            'quantity' => $this->quantity,
            'reserved' => $this->reserved,
        ];
    }
}
