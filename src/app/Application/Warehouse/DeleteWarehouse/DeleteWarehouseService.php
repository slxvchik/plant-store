<?php

declare(strict_types=1);

namespace App\Application\Warehouse\DeleteWarehouse;

use App\Application\Warehouse\Shared\Exception\WarehouseNotFound;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class DeleteWarehouseService implements DeleteWarehouseUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $warehouse = $this->warehouseRepository->findById($id);
        if ($warehouse === null) {
            throw new WarehouseNotFound();
        }

        $this->warehouseRepository->delete($id);
    }
}
