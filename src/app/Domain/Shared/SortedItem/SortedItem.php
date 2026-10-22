<?php

namespace App\Domain\Shared\SortedItem;

/**
 * Value object
 *
 * @template T
 */
readonly class SortedItem
{
    /**
     * @param  T  $id
     */
    public function __construct(
        public mixed $id,
        public int $sort = 500
    ) {}
}
