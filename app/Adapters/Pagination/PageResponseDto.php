<?php

declare(strict_types=1);

namespace App\Adapters\Pagination;

use App\Domain\Shared\Pagination\Page;
use JsonSerializable;
use Override;

/**
 * @template T
 */
readonly class PageResponseDto implements JsonSerializable
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

    public string $firstUrl;

    /**
     * @param  Page<T>  $page
     */
    public function __construct(Page $page, string $url)
    {
        $this->items = $page->items;
        $this->currentPage = $page->pageNumber;
        $this->totalPages = $page->totalPages;
        $this->perPage = $page->pageSize;
        $this->firstUrl = $this->buildUrl($url, 1, $page->pageSize);
        $this->prevUrl = $page->hasPrev ? $this->buildUrl($url, $page->pageNumber - 1, $page->pageSize) : null;

        $prev2Page = $page->pageNumber - 2;
        $this->prev2Url = $prev2Page > 0 ? $this->buildUrl($url, $prev2Page, $page->pageSize) : null;
        $this->nextUrl = $page->hasNext ? $this->buildUrl($url, $page->pageNumber + 1, $page->pageSize) : null;

        $next2Page = $page->pageNumber + 2;
        $this->next2Url = $next2Page <= $page->totalPages ? $this->buildUrl($url, $next2Page, $page->pageSize) : null;
        $this->lastUrl = $page->totalPages > 1 ? $this->buildUrl($url, $page->totalPages, $page->pageSize) : null;
    }

    /**
     * @return array{
     *     items: T[],
     *     currentPage: int,
     *     totalPages: int,
     *     perPage: int,
     *     prevUrl: ?string,
     *     prev2Url: ?string,
     *     nextUrl: ?string,
     *     next2Url: ?string,
     *     lastUrl: ?string,
     *     firstUrl: string
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'perPage' => $this->perPage,
            'prevUrl' => $this->prevUrl,
            'prev2Url' => $this->prev2Url,
            'nextUrl' => $this->nextUrl,
            'next2Url' => $this->next2Url,
            'lastUrl' => $this->lastUrl,
            'firstUrl' => $this->firstUrl,
        ];
    }

    private function buildUrl(string $baseUrl, int $page, int $pageSize): string
    {
        if ($baseUrl === '') {
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
        $queryParams['perPage'] = $pageSize;

        $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'].'://' : '';
        $host = $urlParts['host'] ?? '';
        $port = isset($urlParts['port']) ? ':'.$urlParts['port'] : '';
        $path = $urlParts['path'] ?? '';
        $fragment = isset($urlParts['fragment']) ? '#'.$urlParts['fragment'] : '';

        return $scheme.$host.$port.$path.'?'.http_build_query($queryParams).$fragment;
    }
}
