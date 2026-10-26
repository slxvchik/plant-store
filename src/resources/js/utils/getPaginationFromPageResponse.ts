import type { PageResponse, Pagination } from '@/types/page-response';

export function getPaginationFromPageResponse(
    pageResponse: PageResponse<unknown>,
): Pagination {
    const { items: _items, perPage: _perPage, ...pagination } = pageResponse;

    return pagination;
}
