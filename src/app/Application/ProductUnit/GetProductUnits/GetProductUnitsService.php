<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductUnits;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;
use App\Domain\ProductUnit\ProductUnitCriteria;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetProductUnitsService implements GetProductUnitsUseCase
{
    public function __construct(private ProductUnitRepository $productUnitRepository) {}

    #[Override]
    public function execute(Pageable $pageable, ?ProductUnitCriteria $criteria = null): Page
    {
        $page = $this->productUnitRepository->findPage($pageable, $criteria);
        $productUnits = array_map(ProductUnitResponseDto::fromDomain(...), $page->items);

        return $page->changeItems($productUnits);
    }
}
