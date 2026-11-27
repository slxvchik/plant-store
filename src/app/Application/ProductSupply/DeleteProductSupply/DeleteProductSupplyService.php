<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\DeleteProductSupply;

use App\Application\ProductSupply\Shared\Exception\ProductSupplyNotFoundException;
use App\Domain\ProductSupply\ProductSupplyRepository;
use Override;

readonly class DeleteProductSupplyService implements DeleteProductSupplyUseCase
{
    public function __construct(private ProductSupplyRepository $productSupplyRepository) {}

    #[Override]
    public function execute(string $id): void
    {
        if ($this->productSupplyRepository->findById($id) === null) {
            throw new ProductSupplyNotFoundException($id);
        }

        $this->productSupplyRepository->delete($id);
    }
}
