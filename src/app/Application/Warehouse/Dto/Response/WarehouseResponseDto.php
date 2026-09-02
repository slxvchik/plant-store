<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Dto\Response;

use App\Domain\Warehouse\Models\Warehouse;

readonly class WarehouseResponseDto
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $phoneNumber
    ) {}

    public static function fromDomain(Warehouse $warehouse): self
    {
        return new self(
            id: $warehouse->id->value,
            address: $warehouse->address,
            phoneNumber: $warehouse->phoneNumber
        );
    }
}
