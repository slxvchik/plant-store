<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

use App\Domain\Media\Model\ImageModel;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ImageRepository
{
    public function create(ImageModel $image): string;

    public function update(ImageModel $image): void;

    public function delete(string $id): void;

    public function findById(string $id): ?ImageModel;

    /**
     * @param  string[]  $ids
     * @return ImageModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<ImageModel>
     */
    public function findPage(Pageable $pageable): Page;
}
