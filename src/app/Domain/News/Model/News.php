<?php

declare(strict_types=1);

namespace App\Domain\News\Model;

use App\Domain\Shared\Exception\FieldRequiredException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class News
{
    final public private(set) Uuid $id;

    public private(set) string $alias;

    public private(set) int $sort;

    public private(set) string $name;

    public private(set) bool $active;

    public private(set) ?string $description;

    private function __construct(Uuid $id, string $alias, int $sort, string $name, bool $active, ?string $description)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
        $this->description = $description;
    }

    public static function fromDb(string $id, string $alias, int $sort, string $name, bool $active, ?string $description): self
    {
        $uuid = new Uuid($id);

        return new self(
            id: $uuid,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active,
            description: $description
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidIdentityGenerator, string $alias, int $sort, string $name, bool $active, ?string $description): self
    {
        $uuidValue = $uuidIdentityGenerator->generate();
        $id = new Uuid($uuidValue);

        return new self(
            id: $id,
            alias: $alias,
            sort: $sort,
            name: $name,
            active: $active,
            description: $description
        );
    }

    /**
     * @throws FieldRequiredException
     */
    public function update(string $alias, int $sort, string $name, bool $active, ?string $description): void
    {
        if (empty($alias)) {
            throw new FieldRequiredException('Alias');
        }
        if (empty($name)) {
            throw new FieldRequiredException('Name');
        }
        $this->alias = $alias;
        $this->sort = $sort;
        $this->name = $name;
        $this->active = $active;
        $this->description = $description;
    }
}
