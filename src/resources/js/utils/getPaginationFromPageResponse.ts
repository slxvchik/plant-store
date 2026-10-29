import type { Pagination, Pagination } from '@/types/page-response';

export function getPaginationFromPageResponse(
    pageResponse: Pagination<unknown>,
): Pagination {
    const { items: _items, perPage: _perPage, ...pagination } = pageResponse;

    return pagination;
}
