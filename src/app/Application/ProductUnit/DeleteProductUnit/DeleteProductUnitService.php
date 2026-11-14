<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\DeleteProductUnit;

use App\Application\ProductUnit\Shared\Exception\ProductUnitNotFoundException;
use App\Domain\ProductUnit\ProductUnitRepository;
use Override;

readonly class DeleteProductUnitService implements DeleteProductUnitUseCase
{
    public function __construct(private ProductUnitRepository $productUnitRepository) {}

    #[Override]
    public function execute(string $id): void
    {
        if ($this->productUnitRepository->findById($id) === null) {
            throw new ProductUnitNotFoundException($id);
        }

        $this->productUnitRepository->delete($id);
    }
}
