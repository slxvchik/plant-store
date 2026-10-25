<?php

declare(strict_types=1);

namespace App\Domain\Category\Model;

use App\Domain\Shared\Exception\InternalException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class Category
{
    final public private(set) Uuid $id;

    public private(set) ?Uuid $parentId;

    public private(set) string $alias;

    public private(set) int $sort;

    public private(set) string $name;

    public private(set) bool $active;

    private function __construct(Uuid $id, ?Uuid $parentId, string $alias, int $sort, string $name, bool $active)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
    }

    public static function fromDb(string $id, ?string $parentId, string $alias, int $sort, string $name, bool $active): self
    {
        $uuid = new Uuid($id);
        $parentUuid = $parentId ? new Uuid($parentId) : null;
        return new self(
            id: $uuid,
            parentId: $parentUuid,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, ?string $parentId, string $alias, int $sort, string $name, bool $active): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $id = new Uuid($uuidValue);
        $parentUuid = $parentId ? new Uuid($parentId) : null;
        return new self(
            id: $id,
            parentId: $parentUuid,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active
        );
    }

    /**
     * @throws InternalException
     */
    public function update(?string $parentId, string $alias, int $sort, string $name, bool $active): void
    {
        if ($this->id->value === $parentId) {
            $parentId = null;
        }
        if (empty($alias)) {
            throw new InternalException('Alias');
        }
        if (empty($name)) {
            throw new InternalException('Name');
        }
        $this->parentId = $parentId ? new Uuid($parentId) : null;
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
    }
}
