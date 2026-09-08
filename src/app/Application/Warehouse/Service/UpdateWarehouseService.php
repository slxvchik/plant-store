<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Service;

use App\Application\Warehouse\Dto\Request\UpdateWarehouseRequestDto;
use App\Application\Warehouse\Exception\WarehouseNotFound;
use App\Application\Warehouse\UseCase\UpdateWarehouseUseCase;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

class UpdateWarehouseService implements UpdateWarehouseUseCase
{
    public function __construct(
        private final WarehouseRepository $warehouseRepository
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
