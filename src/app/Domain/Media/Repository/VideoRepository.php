<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

use App\Domain\Media\Model\VideoModel;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface VideoRepository
{
    public function create(VideoModel $video): string;

    public function update(VideoModel $video): void;

    public function delete(string $id): void;

    public function findById(string $id): ?VideoModel;

    /**
     * @param  string[]  $ids
     * @return VideoModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<VideoModel>
     */
    public function findPage(Pageable $pageable): Page;
}
