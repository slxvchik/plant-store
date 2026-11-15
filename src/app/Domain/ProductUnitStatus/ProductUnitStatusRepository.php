<?php

declare(strict_types=1);

namespace App\Domain\ProductUnitStatus;

use App\Domain\ProductUnitStatus\Model\ProductUnitStatusModel;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductUnitStatusRepository
{
    /**
     * @return Page<ProductUnitStatusModel>
     */
    public function findPage(Pageable $pageable): Page;

    /**
     * @return ProductUnitStatusModel[]
     */
    public function findAll(): array;

    public function findById(string $id): ?ProductUnitStatusModel;

    public function findByName(string $name): ?ProductUnitStatusModel;

    public function create(ProductUnitStatusModel $status): string;

    public function update(ProductUnitStatusModel $status): void;

    public function delete(string $id): void;
}
