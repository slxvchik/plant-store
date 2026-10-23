<?php

namespace App\Adapters\Pagination;

use App\Domain\Shared\Pagination\Page;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationAdapter
{
    public static function toDomainPage(LengthAwarePaginator $paginator, callable $mapper): Page
    {
        return new Page(
            items: $paginator->through($mapper)->items(),
            pageNumber: $paginator->currentPage(),
            pageSize: $paginator->perPage(),
            totalPages: $paginator->lastPage(),
            totalCount: $paginator->total(),
            hasPrev: ! $paginator->onFirstPage(),
            hasNext: $paginator->hasMorePages(),
        );
    }
}
