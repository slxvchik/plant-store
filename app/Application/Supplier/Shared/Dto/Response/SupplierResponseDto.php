<?php

declare(strict_types=1);

namespace App\Application\Supplier\Shared\Dto\Response;

use App\Domain\Supplier\SupplierModel;
use JsonSerializable;
use Override;

readonly class SupplierResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $phone,
        public ?string $email,
        public ?string $address,
        public ?string $comment,
    ) {}

    public static function fromDomain(SupplierModel $supplier): self
    {
        return new self(
            id: $supplier->id->value,
            name: $supplier->name,
            phone: $supplier->phone,
            email: $supplier->email,
            address: $supplier->address,
            comment: $supplier->comment,
        );
    }

    /**
     * @return array{id: string, name: string, phone: ?string, email: ?string, address: ?string, comment: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'comment' => $this->comment,
        ];
    }
}
