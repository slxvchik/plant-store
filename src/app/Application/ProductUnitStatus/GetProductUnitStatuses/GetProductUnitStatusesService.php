<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetProductUnitStatuses;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetProductUnitStatusesService implements GetProductUnitStatusesUseCase
{
    public function __construct(private ProductUnitStatusRepository $statusRepository) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->statusRepository->findPage($pageable);
        $statuses = array_map(ProductUnitStatusResponseDto::fromDomain(...), $page->items);

        return $page->changeItems($statuses);
    }
}
