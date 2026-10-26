<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

use App\Domain\Media\Model\Image;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ImageRepository
{
    public function create(Image $image): string;

    public function update(Image $image): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Image;

    /**
     * @param  string[]  $ids
     * @return Image[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<Image>
     */
    public function findPage(Pageable $pageable): Page;
}
