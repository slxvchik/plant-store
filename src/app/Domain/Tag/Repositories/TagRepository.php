<?php

declare(strict_types=1);

namespace App\Domain\Tag\Repositories;

use App\Domain\Shared\BaseRepository\BaseRepository;
use App\Domain\Tag\Models\Tag;

/**
 * @extends BaseRepository<Tag>
 */
interface TagRepository extends BaseRepository
{
    public function findByAlias(string $alias): Tag;
}
