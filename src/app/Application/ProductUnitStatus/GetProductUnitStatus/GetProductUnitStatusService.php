<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetProductUnitStatus;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;
use App\Application\ProductUnitStatus\Shared\Exception\ProductUnitStatusNotFoundException;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use Override;

readonly class GetProductUnitStatusService implements GetProductUnitStatusUseCase
{
    public function __construct(private ProductUnitStatusRepository $statusRepository) {}

    #[Override]
    public function execute(string $id): ProductUnitStatusResponseDto
    {
        $status = $this->statusRepository->findById($id);
        if ($status === null) {
            throw new ProductUnitStatusNotFoundException($id);
        }

        return ProductUnitStatusResponseDto::fromDomain($status);
    }
}
