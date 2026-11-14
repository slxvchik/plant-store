<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductUnitRepository
{
    /**
     * @return Page<ProductUnitModel>
     */
    public function findPage(Pageable $pageable): Page;

    public function findById(string $id): ?ProductUnitModel;

    public function create(ProductUnitModel $productUnit): string;

    public function update(ProductUnitModel $productUnit): void;

    public function delete(string $id): void;
}
