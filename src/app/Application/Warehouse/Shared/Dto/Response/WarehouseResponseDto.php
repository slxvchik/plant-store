<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Shared\Dto\Response;

use App\Domain\Warehouse\Model\Warehouse;
use JsonSerializable;
use Override;

readonly class WarehouseResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $phoneNumber,
    ) {}

    public static function fromDomain(Warehouse $warehouse): self
    {
        return new self(
            id: $warehouse->id->value,
            address: $warehouse->address,
            phoneNumber: $warehouse->phoneNumber,
        );
    }

    /**
     * @return array{id: string, address: string, phone: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'phone' => $this->phoneNumber,
        ];
    }
}
