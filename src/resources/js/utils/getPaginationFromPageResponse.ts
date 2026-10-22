import type { PageResponse, Pagination } from '@/types/page-response.ts';

export function getPaginationFromPageResponse(
    pageResponse: PageResponse<any>,
): Pagination {
    const {
        items: _items,
        perPage: _perPage,
        ...paginationWithoutItemsAndPerPage
    } = pageResponse;

    return paginationWithoutItemsAndPerPage;
}
