<?php

declare(strict_types=1);

namespace App\Application\Supplier\CreateSupplier;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Supplier\SupplierModel;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class CreateSupplierService implements CreateSupplierUseCase
{
    public function __construct(
        private SupplierRepository $supplierRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Override]
    public function execute(CreateSupplierRequestDto $createSupplierRequestDto): string
    {
        $supplier = SupplierModel::createNew(
            uuidGenerator: $this->uuidGenerator,
            name: $createSupplierRequestDto->name,
            phone: $createSupplierRequestDto->phone,
            email: $createSupplierRequestDto->email,
            address: $createSupplierRequestDto->address,
            comment: $createSupplierRequestDto->comment,
        );

        return $this->supplierRepository->create($supplier);
    }
}
