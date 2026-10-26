<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

use App\Domain\Media\Model\Video;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface VideoRepository
{
    public function create(Video $video): string;

    public function update(Video $video): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Video;

    /**
     * @param  string[]  $ids
     * @return Video[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<Video>
     */
    public function findPage(Pageable $pageable): Page;
}
