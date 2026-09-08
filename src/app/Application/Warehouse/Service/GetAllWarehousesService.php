<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Service;

use App\Application\Warehouse\Dto\Response\WarehouseResponseDto;
use App\Application\Warehouse\UseCase\GetAllWarehousesUseCase;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

class GetAllWarehousesService implements GetAllWarehousesUseCase
{
    public function __construct(
        private final WarehouseRepository $warehouseRepository
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
