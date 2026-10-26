<?php

declare(strict_types=1);

namespace App\Adapters\Pagination;

use App\Domain\Shared\Pagination\Page;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationAdapter
{
    /**
     * @template T
     * @template U
     *
     * @param  LengthAwarePaginator<int, T>  $paginator
     * @param  callable(T): U  $mapper
     * @return Page<U>
     */
    public static function toDomainPage(LengthAwarePaginator $paginator, callable $mapper): Page
    {
        return new Page(
            items: $paginator->getCollection()->map($mapper)->all(),
            pageNumber: $paginator->currentPage(),
            pageSize: $paginator->perPage(),
            totalPages: $paginator->lastPage(),
            totalCount: $paginator->total(),
            hasPrev: ! $paginator->onFirstPage(),
            hasNext: $paginator->hasMorePages(),
        );
    }
}
