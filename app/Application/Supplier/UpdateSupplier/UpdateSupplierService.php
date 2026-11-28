<?php

declare(strict_types=1);

namespace App\Application\Supplier\UpdateSupplier;

use App\Application\Supplier\Shared\Exception\SupplierAlreadyExistsException;
use App\Application\Supplier\Shared\Exception\SupplierNotFoundException;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class UpdateSupplierService implements UpdateSupplierUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(UpdateSupplierRequestDto $requestDto): void
    {
        $supplier = $this->supplierRepository->findById($requestDto->id);
        if ($supplier === null) {
            throw new SupplierNotFoundException($requestDto->id);
        }

        $sameName = $this->supplierRepository->findByName($requestDto->name);
        if ($sameName !== null && $sameName->id->value !== $supplier->id->value) {
            throw new SupplierAlreadyExistsException('названием', $requestDto->name);
        }

        if ($requestDto->email !== null && $requestDto->email !== '') {
            $sameEmail = $this->supplierRepository->findByEmail($requestDto->email);
            if ($sameEmail !== null && $sameEmail->id->value !== $supplier->id->value) {
                throw new SupplierAlreadyExistsException('email', $requestDto->email);
            }
        }

        $supplier->update(
            name: $requestDto->name,
            phone: $requestDto->phone,
            email: $requestDto->email,
            address: $requestDto->address,
            comment: $requestDto->comment,
        );

        $this->supplierRepository->update($supplier);
    }
}
