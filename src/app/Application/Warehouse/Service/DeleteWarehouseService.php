<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Service;

use App\Application\Warehouse\Exception\WarehouseNotFound;
use App\Application\Warehouse\UseCase\DeleteWarehouseUseCase;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

class DeleteWarehouseService implements DeleteWarehouseUseCase
{
    public function __construct(
        private final WarehouseRepository $warehouseRepository
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
