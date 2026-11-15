<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\CreateProductSupply;

use App\Domain\ProductSupply\ProductSupplyModel;
use App\Domain\ProductSupply\ProductSupplyRepository;
use App\Domain\ProductUnit\ProductUnitModel;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Illuminate\Support\Facades\DB;
use Override;

readonly class CreateProductSupplyService implements CreateProductSupplyUseCase
{
    public function __construct(
        private ProductSupplyRepository $productSupplyRepository,
        private ProductUnitRepository $productUnitRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Override]
    public function execute(CreateProductSupplyRequestDto $requestDto): string
    {
        return DB::transaction(function () use ($requestDto): string {
            $productSupply = ProductSupplyModel::createNew(
                uuidGenerator: $this->uuidGenerator,
                supplierId: $requestDto->supplierId,
                offerId: $requestDto->offerId,
                productUnitIds: [],
                declaredQuantity: $requestDto->declaredQuantity,
                actualQuantity: $requestDto->actualQuantity,
                unitPurchasePriceInKopecks: $requestDto->unitPurchasePriceInKopecks,
                totalPurchasePriceInKopecks: $requestDto->totalPurchasePriceInKopecks,
                comment: $requestDto->comment,
                misGraded: $requestDto->misGraded,
            );

            $productSupplyId = $this->productSupplyRepository->create($productSupply);
            $productUnits = [];

            for ($unitNumber = 0; $unitNumber < $requestDto->actualQuantity; $unitNumber++) {
                $productUnits[] = ProductUnitModel::createNew(
                    uuidGenerator: $this->uuidGenerator,
                    productSupplyId: $productSupplyId,
                    offerId: $requestDto->offerId,
                    warehouseId: $requestDto->warehouseId,
                    productUnitStatusId: $requestDto->initialProductUnitStatusId,
                    qrCode: null,
                );
            }

            $this->productUnitRepository->createMany($productUnits);

            return $productSupplyId;
        });
    }
}
