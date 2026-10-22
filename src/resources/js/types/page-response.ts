export type PageResponse<T> = {
    items: T[];
    currentPage: number;
    totalPages: number;
    perPage: number;
    prevUrl?: string;
    prev2Url?: string;
    nextUrl?: string;
    next2Url?: string;
    firstUrl?: string;
    lastUrl?: string;
};

export type Pagination = {
    currentPage: number;
    totalPages: number;
    prevUrl?: string;
    prev2Url?: string;
    nextUrl?: string;
    next2Url?: string;
    firstUrl?: string;
    lastUrl?: string;
}
