<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\UpdateProductSupply;

use App\Application\ProductSupply\Shared\Exception\ProductSupplyNotFoundException;
use App\Domain\ProductSupply\ProductSupplyRepository;
use Override;

readonly class UpdateProductSupplyService implements UpdateProductSupplyUseCase
{
    public function __construct(private ProductSupplyRepository $productSupplyRepository) {}

    #[Override]
    public function execute(UpdateProductSupplyRequestDto $requestDto): void
    {
        $productSupply = $this->productSupplyRepository->findById($requestDto->id);
        if ($productSupply === null) {
            throw new ProductSupplyNotFoundException($requestDto->id);
        }

        $productSupply->update(
            supplierId: $requestDto->supplierId,
            offerId: $requestDto->offerId,
            declaredQuantity: $requestDto->declaredQuantity,
            actualQuantity: $requestDto->actualQuantity,
            unitPurchasePriceInKopecks: $requestDto->unitPurchasePriceInKopecks,
            totalPurchasePriceInKopecks: $requestDto->totalPurchasePriceInKopecks,
            comment: $requestDto->comment,
            misGraded: $requestDto->misGraded,
        );

        $this->productSupplyRepository->update($productSupply);
    }
}
