<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetProductSupply;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;
use App\Application\ProductSupply\Shared\Exception\ProductSupplyNotFoundException;
use App\Domain\ProductSupply\ProductSupplyRepository;
use Override;

readonly class GetProductSupplyService implements GetProductSupplyUseCase
{
    public function __construct(private ProductSupplyRepository $productSupplyRepository) {}

    #[Override]
    public function execute(string $id): ProductSupplyResponseDto
    {
        $productSupply = $this->productSupplyRepository->findById($id);
        if ($productSupply === null) {
            throw new ProductSupplyNotFoundException($id);
        }

        return ProductSupplyResponseDto::fromDomain($productSupply);
    }
}
