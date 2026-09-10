<?php

declare(strict_types=1);

namespace App\Application\Warehouse\UpdateWarehouse;

use App\Application\Warehouse\Shared\Exception\WarehouseNotFound;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class UpdateWarehouseService implements UpdateWarehouseUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository
    ) {}

    #[Override]
    public function execute(UpdateWarehouseRequestDto $updateWarehouseRequestDto): void
    {
        $warehouse = $this->warehouseRepository->findById($updateWarehouseRequestDto->id);
        if ($warehouse === null) {
            throw new WarehouseNotFound();
        }

        $warehouse->update(
            address: $updateWarehouseRequestDto->address,
            phoneNumber: $updateWarehouseRequestDto->phoneNumber
        );

        $this->warehouseRepository->update($warehouse);
    }
}
