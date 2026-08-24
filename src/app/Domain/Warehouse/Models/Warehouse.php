<?php

declare(strict_types=1);

namespace App\Domain\Warehouse\Models;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Warehouse
{
    private(set) final Uuid $id;
    private(set) string $address;
    private(set) ?string $phoneNumber;

    private function __construct(Uuid $id, string $address, ?string $phoneNumber)
    {
        $this->id = $id;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public static function fromDb(string $id, string $address, ?string $phoneNumber): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            address: $address,
            phoneNumber: $phoneNumber
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, string $address, ?string $phoneNumber): self
    {
        $id = $uuidGeneratorInterface->generate();
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            address: $address,
            phoneNumber: $phoneNumber
        );
    }

    public function update(string $address, ?string $phoneNumber)
    {
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }
}
