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
     * @param T $entity
     * @return string id
     */
    function create(object $entity): string;

    /**
     * @param T $entity
     */
    function update(object $entity): void;
    function delete(string $id): void;
    /**
     * @param string|int $id
     * @return T|null
     */
    function findById(string|int $id): ?object;
    /**
     * @return Page<T>
     */
    function findPage(Pageable $pageable): Page;
    /**
     * @return T[]
     */
    function findAll(): array;
}
