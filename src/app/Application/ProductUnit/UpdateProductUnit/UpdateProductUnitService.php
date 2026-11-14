<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\UpdateProductUnit;

use App\Application\ProductUnit\Shared\Exception\ProductUnitNotFoundException;
use App\Domain\ProductUnit\ProductUnitRepository;
use Override;

readonly class UpdateProductUnitService implements UpdateProductUnitUseCase
{
    public function __construct(private ProductUnitRepository $productUnitRepository) {}

    #[Override]
    public function execute(UpdateProductUnitRequestDto $requestDto): void
    {
        $productUnit = $this->productUnitRepository->findById($requestDto->id);
        if ($productUnit === null) {
            throw new ProductUnitNotFoundException($requestDto->id);
        }

        $productUnit->update(
            productSupplyId: $requestDto->productSupplyId,
            offerId: $requestDto->offerId,
            warehouseId: $requestDto->warehouseId,
            reserved: $requestDto->reserved,
            sowingDate: $requestDto->sowingDate,
            productUnitStatusId: $requestDto->productUnitStatusId,
            comments: $requestDto->comments,
            qrCode: $requestDto->qrCode,
        );

        $this->productUnitRepository->update($productUnit);
    }
}
