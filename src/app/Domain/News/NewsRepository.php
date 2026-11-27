<?php

declare(strict_types=1);

namespace App\Domain\News;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface NewsRepository
{
    public function create(NewsModel $news): string;

    public function update(NewsModel $news): void;

    public function delete(string $id): void;

    public function findById(string $id): ?NewsModel;

    public function findByAlias(string $alias): ?NewsModel;

    /**
     * @return Page<NewsModel>
     */
    public function findPage(Pageable $pageable): Page;
}
