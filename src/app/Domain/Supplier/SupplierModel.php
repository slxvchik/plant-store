<?php

namespace App\Domain\Supplier;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

/**
 * Product supplier
 */
class SupplierModel
{
    public private(set) Uuid $id;

    public private(set) string $name;

    public private(set) ?string $phone;

    public private(set) ?string $email;

    public private(set) ?string $address;

    public private(set) string $comment;

    /**
     * @param string $id
     * @param string $name
     * @param string|null $phone
     * @param string|null $email
     * @param string|null $address
     * @param string $comment
     */
    private function __construct(string $id, string $name, ?string $phone, ?string $email, ?string $address, string $comment)
    {
        $uuid = new Uuid($id);
        $this->id = $uuid;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->comment = $comment;
    }

    public static function createNew(UuidGeneratorInterface $uuidGenerator, string $name, ?string $phone, ?string $email, ?string $address, string $comment): self
    {
        return new self($uuidGenerator->generate(), $name, $phone, $email, $address, $comment);
    }

    public static function fromDb(string $id, string $name, ?string $phone, ?string $email, ?string $address, string $comment): self
    {
        return new self($id, $name, $phone, $email, $address, $comment);
    }

    public function update(string $name, ?string $phone, ?string $email, ?string $address, string $comment): void
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->comment = $comment;
    }
}
