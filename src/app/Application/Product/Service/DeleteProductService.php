<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use App\Application\Cart\UseCase\DeleteProductUseCase;
use App\Application\Product\Exception\ProductNotFoundException;
use App\Domain\Product\Repository\ProductRepository;
use Override;

class DeleteProductService implements DeleteProductUseCase
{
    public function __construct(
        private final ProductRepository $productRepository
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $product = $this->productRepository->findById($id);
        if ($product === null) {
            throw new ProductNotFoundException();
        }

        $this->productRepository->delete($id);
    }
}
