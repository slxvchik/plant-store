<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductOptions;

use App\Application\Product\Shared\Dto\Response\ProductOptionResponseDto;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class GetProductOptionsService implements GetProductOptionsUseCase
{
    public function __construct(private ProductRepository $productRepository) {}

    #[Override]
    public function execute(): array
    {
        return array_map(ProductOptionResponseDto::fromDomain(...), $this->productRepository->findAll());
    }
}
