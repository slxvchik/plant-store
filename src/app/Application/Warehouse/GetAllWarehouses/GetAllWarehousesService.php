<?php

declare(strict_types=1);

namespace App\Application\Warehouse\GetAllWarehouses;

use App\Application\Warehouse\Shared\Dto\Response\WarehouseResponseDto;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class GetAllWarehousesService implements GetAllWarehousesUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository
    ) {}

    #[Override]
    public function execute(): array
    {
        $warehouses = $this->warehouseRepository->findAll();

        $warehousesResult = [];
        foreach ($warehouses as $warehouse) {
            $warehousesResult[] = WarehouseResponseDto::fromDomain($warehouse);
        }

        return $warehouses;
    }
}
