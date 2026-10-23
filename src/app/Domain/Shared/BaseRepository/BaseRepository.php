<?php

namespace App\Domain\Shared\BaseRepository;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

/**
 * @template T
 */
interface BaseRepository
{
    /**
     * @param  T  $entity
     * @return string id
     */
    public function create(object $entity): string;

    /**
     * @param  T  $entity
     */
    public function update(object $entity): void;

    public function delete(string $id): void;

    /**
     * @param string|int $id
     * @return T|null
     */
    public function findById(string|int $id): ?object;

    /**
     * @param  string[]|int[]  $ids
     * @return T[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<T>
     */
    public function findPage(Pageable $pageable): Page;

    /**
     * @return T[]
     */
    public function findAll(): array;
}
