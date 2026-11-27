<?php

declare(strict_types=1);

namespace App\Domain\MainPageGallery;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface MainPageGalleryRepository
{
    public function create(MainPageGalleryModel $slide): string;

    public function update(MainPageGalleryModel $slide): void;

    public function delete(string $id): void;

    public function findById(string $id): ?MainPageGalleryModel;

    public function findPage(Pageable $pageable): Page;

    /**
     * @return MainPageGalleryModel[]
     */
    public function search(?bool $active = null): array;
}
