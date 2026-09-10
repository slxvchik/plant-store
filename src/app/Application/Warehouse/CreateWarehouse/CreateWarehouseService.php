<?php

declare(strict_types=1);

namespace App\Application\Warehouse\CreateWarehouse;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Warehouse\Model\Warehouse;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class CreateWarehouseService implements CreateWarehouseUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private WarehouseRepository $warehouseRepository
    ) {}

    #[Override]
    public function execute(CreateWarehouseRequestDto $createWarehouseRequestDto): string
    {
        $newWareHouse = Warehouse::createNew(
            uuidGeneratorInterface: $this->uuidGeneratorInterface,
            address: $createWarehouseRequestDto->address,
            phoneNumber: $createWarehouseRequestDto->phoneNumber
        );

        return $this->warehouseRepository->create($newWareHouse);
    }
}
