<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetProductSupplies;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;
use App\Domain\ProductSupply\ProductSupplyRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetProductSuppliesService implements GetProductSuppliesUseCase
{
    public function __construct(private ProductSupplyRepository $productSupplyRepository) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->productSupplyRepository->findPage($pageable);
        $productSupplies = array_map(ProductSupplyResponseDto::fromDomain(...), $page->items);

        return $page->changeItems($productSupplies);
    }
}
