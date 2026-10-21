<?php

declare(strict_types=1);

namespace App\Domain\Category\Model;

use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Category
{
    private(set) final Uuid $id;
    private(set) string $alias;
    private(set) ?int $sort;
    private(set) string $name;
    private(set) bool $active;

    private function __construct(Uuid $id, string $alias, ?int $sort, string $name, bool $active)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
    }

    public static function fromDb(string $id, string $alias, ?int $sort, string $name, bool $active): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, string $alias, ?int $sort, string $name, bool $active): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $id = new Uuid($uuidValue);
        return new self(
            id: $id,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active
        );
    }

    /**
     * @throws InternalException
     */
    public function update(string $alias, ?int $sort, string $name, bool $active): void
    {
        if (empty($alias)) {
            throw new InternalException("Alias");
        }
        if (empty($name)) {
            throw new InternalException("Name");
        }
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
    }
}
