<?php

declare(strict_types=1);

namespace App\Domain\MainPageGallery\Repository;

use App\Domain\MainPageGallery\Model\MainPageGallery;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface MainPageGalleryRepository
{
    public function create(MainPageGallery $slide): string;

    public function update(MainPageGallery $slide): void;

    public function delete(string $id): void;

    public function findById(string $id): ?MainPageGallery;

    public function findPage(Pageable $pageable): Page;

    /**
     * @return MainPageGallery[]
     */
    public function search(?bool $active = null): array;
}
