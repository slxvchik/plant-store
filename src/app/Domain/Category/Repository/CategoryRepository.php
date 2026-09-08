<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Model\Category;
use App\Domain\Shared\BaseRepository\BaseRepository;

/**
 * @extends BaseRepository<Category>
 */
interface CategoryRepository extends BaseRepository
{
    public function findByAlias(string $alias): Category;
}
