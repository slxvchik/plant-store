<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetAllProductUnitStatuses;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use Override;

readonly class GetAllProductUnitStatusesService implements GetAllProductUnitStatusesUseCase
{
    public function __construct(private ProductUnitStatusRepository $statusRepository) {}

    #[Override]
    public function execute(): array
    {
        return array_map(ProductUnitStatusResponseDto::fromDomain(...), $this->statusRepository->findAll());
    }
}
