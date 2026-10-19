export type PageResponse<T> = {
    items: T[];
    currentPage: bigint;
    totalPages: bigint;
    perPage: bigint;
    prevUrl?: string;
    prev2Url?: string;
    nextUrl?: string;
    next2Url?: string;
    firstUrl?: string;
    lastUrl?: string;
};
