export type Page<T> = {
    items: T[];
    currentPage: number;
    totalPages: number;
    perPage: number;
    prevUrl: string | null;
    prev2Url: string | null;
    nextUrl: string | null;
    next2Url: string | null;
    firstUrl: string;
    lastUrl: string | null;
};

export type Pagination = Omit<Page<never>, 'items' | 'perPage'>;
