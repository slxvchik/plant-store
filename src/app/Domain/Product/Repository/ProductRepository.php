<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Product;
use App\Domain\Shared\BaseRepository\BaseRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

/**
 * @extends BaseRepository<Product>
 */
interface ProductRepository extends BaseRepository
{
    /**
     * @return Product|null
     */
    public function findByAlias(string $alias): ?Product;

    /**
     * @return Page<Product>
     */
    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page;
}
