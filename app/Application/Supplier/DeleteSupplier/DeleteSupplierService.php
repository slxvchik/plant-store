<?php

declare(strict_types=1);

namespace App\Application\Supplier\DeleteSupplier;

use App\Application\Supplier\Shared\Exception\SupplierNotFoundException;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class DeleteSupplierService implements DeleteSupplierUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(string $id): void
    {
        if ($this->supplierRepository->findById($id) === null) {
            throw new SupplierNotFoundException($id);
        }

        $this->supplierRepository->delete($id);
    }
}
