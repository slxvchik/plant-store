<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetAllProductSupplies;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;
use App\Domain\ProductSupply\ProductSupplyRepository;
use Override;

readonly class GetAllProductSuppliesService implements GetAllProductSuppliesUseCase
{
    public function __construct(private ProductSupplyRepository $productSupplyRepository) {}

    #[Override]
    public function execute(): array
    {
        return array_map(ProductSupplyResponseDto::fromDomain(...), $this->productSupplyRepository->findAll());
    }
}
