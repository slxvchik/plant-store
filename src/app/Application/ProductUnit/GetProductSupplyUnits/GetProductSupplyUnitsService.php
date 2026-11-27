<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductSupplyUnits;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;
use App\Domain\ProductUnit\ProductUnitRepository;
use Override;

readonly class GetProductSupplyUnitsService implements GetProductSupplyUnitsUseCase
{
    public function __construct(private ProductUnitRepository $productUnitRepository) {}

    #[Override]
    public function execute(string $supplyId): array
    {
        return array_map(ProductUnitResponseDto::fromDomain(...), $this->productUnitRepository->findBySupplyId($supplyId));
    }
}
