<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductUnit;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;
use App\Application\ProductUnit\Shared\Exception\ProductUnitNotFoundException;
use App\Domain\ProductUnit\ProductUnitRepository;
use Override;

readonly class GetProductUnitService implements GetProductUnitUseCase
{
    public function __construct(private ProductUnitRepository $productUnitRepository) {}

    #[Override]
    public function execute(string $id): ProductUnitResponseDto
    {
        $productUnit = $this->productUnitRepository->findById($id);
        if ($productUnit === null) {
            throw new ProductUnitNotFoundException($id);
        }

        return ProductUnitResponseDto::fromDomain($productUnit);
    }
}
