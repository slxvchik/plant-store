<?php

declare(strict_types=1);

namespace App\Domain\MainPageGallery\Repository;

use App\Domain\MainPageGallery\Model\MainPageGallery;

interface MainPageGalleryRepository
{
    public function create(MainPageGallery $slide): string;

    public function update(MainPageGallery $slide): void;

    public function delete(string $id): void;

    public function findById(string $id): ?MainPageGallery;

    /**
     * @return MainPageGallery[]
     */
    public function findAll(): array;
}
