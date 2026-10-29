<?php

declare(strict_types=1);

namespace App\Domain\News\Repository;

use App\Domain\News\Model\News;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface NewsRepository
{
    public function create(News $news): string;

    public function update(News $news): void;

    public function delete(string $id): void;

    public function findById(string $id): ?News;

    public function findByAlias(string $alias): ?News;

    /**
     * @return Page<News>
     */
    public function findPage(Pageable $pageable): Page;
}
