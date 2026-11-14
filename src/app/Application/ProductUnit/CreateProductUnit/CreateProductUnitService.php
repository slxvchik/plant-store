<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\CreateProductUnit;

use App\Domain\ProductUnit\ProductUnitModel;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateProductUnitService implements CreateProductUnitUseCase
{
    public function __construct(
        private ProductUnitRepository $productUnitRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Override]
    public function execute(CreateProductUnitRequestDto $requestDto): string
    {
        $productUnit = ProductUnitModel::createNew(
            uuidGenerator: $this->uuidGenerator,
            productSupplyId: $requestDto->productSupplyId,
            offerId: $requestDto->offerId,
            warehouseId: $requestDto->warehouseId,
            productUnitStatusId: $requestDto->productUnitStatusId,
            reserved: $requestDto->reserved,
            sowingDate: $requestDto->sowingDate,
            comments: $requestDto->comments,
            qrCode: $requestDto->qrCode,
        );

        return $this->productUnitRepository->create($productUnit);
    }
}
