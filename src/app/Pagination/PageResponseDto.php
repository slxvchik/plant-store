<?php

namespace App\Pagination;

use App\Domain\Shared\Pagination\Page;

/**
 * @template T
 */
readonly class PageResponseDto
{
    /**
     * @var T[]
     */
    public array $items;

    public int $currentPage;

    public int $totalPages;

    public int $perPage;

    public ?string $prevUrl;

    public ?string $prev2Url;

    public ?string $nextUrl;

    public ?string $next2Url;

    public ?string $lastUrl;

    public ?string $firstUrl;

    public function __construct(
        Page $page,
        string $url
    ) {
        $this->items = $page->items;
        $this->currentPage = $page->pageNumber;
        $this->totalPages = $page->totalPages;
        $this->perPage = $page->pageSize;

        $this->firstUrl = $page->totalPages > 0 ? $this->buildUrl($url, 1, $page->pageSize) : null;

        $this->prevUrl = $page->hasPrev ? $this->buildUrl($url, $page->pageNumber - 1, $page->pageSize) : null;

        $prev2Page = $page->pageNumber - 2;
        $this->prev2Url = $prev2Page > 0 ? $this->buildUrl($url, $prev2Page, $page->pageSize) : null;

        $this->nextUrl = $page->hasNext ? $this->buildUrl($url, $page->pageNumber + 1, $page->pageSize) : null;

        $next2Page = $page->pageNumber + 2;
        $this->next2Url = $next2Page <= $page->totalPages ? $this->buildUrl($url, $next2Page, $page->pageSize) : null;

        $this->lastUrl = $page->totalPages > 0 ? $this->buildUrl($url, $page->totalPages, $page->pageSize) : null;
    }

    private function buildUrl(string $baseUrl, int $page, int $pageSize): string
    {
        if (empty($baseUrl)) {
            return '';
        }

        $urlParts = parse_url($baseUrl);

        if ($urlParts === false) {
            return '';
        }

        $queryParams = [];

        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $queryParams);
        }

        $queryParams['page'] = $page;
        $queryParams['pageSize'] = $pageSize;

        $query = http_build_query($queryParams);

        $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'].'://' : '';
        $host = $urlParts['host'] ?? '';
        $path = $urlParts['path'] ?? '';
        $fragment = isset($urlParts['fragment']) ? '#'.$urlParts['fragment'] : '';

        return $scheme.$host.$path.'?'.$query.$fragment;
    }
}
