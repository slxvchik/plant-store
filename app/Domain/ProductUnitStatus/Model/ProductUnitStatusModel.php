<?php

declare(strict_types=1);

namespace App\Domain\ProductUnitStatus\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class ProductUnitStatusModel
{
    public private(set) Uuid $id;

    public private(set) string $name;

    public private(set) ?string $comment;

    private function __construct(Uuid $id, string $name, ?string $comment)
    {
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
    }

    public static function createNew(UuidGeneratorInterface $uuidGenerator, string $name, ?string $comment): self
    {
        return new self(new Uuid($uuidGenerator->generate()), $name, $comment);
    }

    public static function fromDb(string $id, string $name, ?string $comment): self
    {
        return new self(new Uuid($id), $name, $comment);
    }

    public function update(string $name, ?string $comment): void
    {
        $this->name = $name;
        $this->comment = $comment;
    }
}
