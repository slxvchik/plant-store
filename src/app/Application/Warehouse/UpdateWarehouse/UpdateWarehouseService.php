<?php

declare(strict_types=1);

namespace App\Application\Warehouse\UpdateWarehouse;

use App\Application\Warehouse\Shared\Exception\WarehouseNotFound;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Illuminate\Support\Facades\Log;
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
        Log::debug(print_r($warehouse, true));
        $warehouse->update(
            address: $updateWarehouseRequestDto->address,
            phoneNumber: $updateWarehouseRequestDto->phoneNumber
        );

        $this->warehouseRepository->update($warehouse);
    }
}
