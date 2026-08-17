<?php

declare(strict_types=1);

namespace App\Domain\Product\Models;

use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Category
{
    private(set) Uuid $id;
    private(set) string $alias;
    private(set) string $name;
    private(set) bool $active;

    private function __construct(Uuid $id, string $alias, string $name, bool $active)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->name = $name;
        $this->active = $active;
    }

    public static function fromDb(string $id, string $alias, string $name, bool $active): self
    {
        $uuid = new Uuid($id);
        return new self(
            $uuid,
            $alias,
            $name,
            $active
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, string $alias, string $name, bool $active): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $id = new Uuid($uuidValue);
        return new self(
            $id,
            $alias,
            $name,
            $active
        );
    }

    public function update(string $alias, string $name, bool $active): void
    {
        if (empty($alias)) {
            throw new FieldRequiredException("Alias");
        }
        if (empty($name)) {
            throw new FieldRequiredException("Name");
        }
        $this->alias = $alias;
        $this->name = $name;
        $this->active = $active;
    }
}
