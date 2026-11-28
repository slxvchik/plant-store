<?php

namespace App\Domain\Shared\SortedItem;

/**
 * Value object.
 * In array sort number must be unique.
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
        public int $sort
    ) {}
}
