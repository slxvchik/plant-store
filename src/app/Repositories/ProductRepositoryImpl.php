<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use LogicException;
use Override;

class ProductRepositoryImpl implements ProductRepository
{
    #[Override]
    public function create(Product $product): string
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function update(Product $product): void
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function delete(string $id): void
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function findById(string $id): ?Product
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function findByAlias(string $alias): ?Product
    {
        throw new LogicException('Product persistence is not implemented.');
    }

    #[Override]
    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page
    {
        throw new LogicException('Product persistence is not implemented.');
    }
}
