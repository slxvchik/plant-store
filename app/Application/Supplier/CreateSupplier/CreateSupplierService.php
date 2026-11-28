<?php

declare(strict_types=1);

namespace App\Application\Supplier\CreateSupplier;

use App\Application\Supplier\Shared\Exception\SupplierAlreadyExistsException;
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
    public function execute(CreateSupplierRequestDto $requestDto): string
    {
        if ($this->supplierRepository->findByName($requestDto->name) !== null) {
            throw new SupplierAlreadyExistsException('названием', $requestDto->name);
        }

        if ($requestDto->email !== null && $requestDto->email !== '' && $this->supplierRepository->findByEmail($requestDto->email) !== null) {
            throw new SupplierAlreadyExistsException('email', $requestDto->email);
        }

        $supplier = SupplierModel::createNew(
            uuidGenerator: $this->uuidGenerator,
            name: $requestDto->name,
            phone: $requestDto->phone,
            email: $requestDto->email,
            address: $requestDto->address,
            comment: $requestDto->comment,
        );

        return $this->supplierRepository->create($supplier);
    }
}
