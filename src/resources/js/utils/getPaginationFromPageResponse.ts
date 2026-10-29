import type { Page, Pagination } from '@/types/pagination.ts';

export function getPaginationFromPageResponse(
    pageResponse: Page<unknown>,
): Pagination {
    const { items: _items, perPage: _perPage, ...pagination } = pageResponse;

    return pagination;
}
