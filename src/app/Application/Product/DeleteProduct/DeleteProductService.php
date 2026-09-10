<?php

declare(strict_types=1);

namespace App\Application\Product\DeleteProduct;

use App\Application\Cart\DeleteProduct\DeleteProductUseCase;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class DeleteProductService implements DeleteProductUseCase
{
    public function __construct(
        private ProductRepository $productRepository
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
