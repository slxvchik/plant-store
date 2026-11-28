<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetSupplier;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;
use App\Application\Supplier\Shared\Exception\SupplierNotFoundException;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class GetSupplierService implements GetSupplierUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(string $id): SupplierResponseDto
    {
        $supplier = $this->supplierRepository->findById($id);
        if ($supplier === null) {
            throw new SupplierNotFoundException($id);
        }

        return SupplierResponseDto::fromDomain($supplier);
    }
}
