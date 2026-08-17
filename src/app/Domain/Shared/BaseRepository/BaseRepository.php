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
     * @param string $id
     * @return T
     */
    function findById(string $id): object;
    /**
     * @return Page<T>
     */
    function findAll(Pageable $pageable): Page;
}
