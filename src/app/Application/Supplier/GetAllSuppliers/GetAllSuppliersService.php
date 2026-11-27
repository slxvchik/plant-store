<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetAllSuppliers;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class GetAllSuppliersService implements GetAllSuppliersUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(): array
    {
        return array_map(SupplierResponseDto::fromDomain(...), $this->supplierRepository->findAll());
    }
}
