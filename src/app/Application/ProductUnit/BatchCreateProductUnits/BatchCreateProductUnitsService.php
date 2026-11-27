<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\BatchCreateProductUnits;

use App\Domain\ProductUnit\ProductUnitModel;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Contracts\Transactional;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class BatchCreateProductUnitsService implements BatchCreateProductUnitsUseCase
{
    public function __construct(
        private ProductUnitRepository $productUnitRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Transactional]
    #[Override]
    public function execute(BatchCreateProductUnitsRequestDto $requestDto): array
    {
        $productUnits = [];
        $ids = [];

        for ($unitNumber = 0; $unitNumber < $requestDto->quantity; $unitNumber++) {
            $productUnit = ProductUnitModel::createNew(
                uuidGenerator: $this->uuidGenerator,
                productSupplyId: $requestDto->productSupplyId,
                offerId: $requestDto->offerId,
                warehouseId: $requestDto->warehouseId,
                productUnitStatusId: $requestDto->productUnitStatusId,
                sowingDate: $requestDto->sowingDate,
                comments: $requestDto->comments,
            );
            $productUnits[] = $productUnit;
            $ids[] = $productUnit->id->value;
        }

        $this->productUnitRepository->createMany($productUnits);

        return $ids;
    }
}
