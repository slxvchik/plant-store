<?php

declare(strict_types=1);

namespace App\Application\Supplier\UpdateSupplier;

use App\Application\Supplier\Shared\Exception\SupplierNotFoundException;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class UpdateSupplierService implements UpdateSupplierUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(UpdateSupplierRequestDto $updateSupplierRequestDto): void
    {
        $supplier = $this->supplierRepository->findById($updateSupplierRequestDto->id);
        if ($supplier === null) {
            throw new SupplierNotFoundException($updateSupplierRequestDto->id);
        }

        $supplier->update(
            name: $updateSupplierRequestDto->name,
            phone: $updateSupplierRequestDto->phone,
            email: $updateSupplierRequestDto->email,
            address: $updateSupplierRequestDto->address,
            comment: $updateSupplierRequestDto->comment,
        );

        $this->supplierRepository->update($supplier);
    }
}
