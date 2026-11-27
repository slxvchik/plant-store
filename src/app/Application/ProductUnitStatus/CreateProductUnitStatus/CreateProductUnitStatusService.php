<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\CreateProductUnitStatus;

use App\Application\ProductUnitStatus\Shared\Exception\ProductUnitStatusAlreadyExistsException;
use App\Domain\ProductUnitStatus\Model\ProductUnitStatusModel;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateProductUnitStatusService implements CreateProductUnitStatusUseCase
{
    public function __construct(
        private ProductUnitStatusRepository $statusRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    #[Override]
    public function execute(CreateProductUnitStatusRequestDto $requestDto): string
    {
        if ($this->statusRepository->findByName($requestDto->name) !== null) {
            throw new ProductUnitStatusAlreadyExistsException($requestDto->name);
        }

        $status = ProductUnitStatusModel::createNew($this->uuidGenerator, $requestDto->name, $requestDto->comment);

        return $this->statusRepository->create($status);
    }
}
