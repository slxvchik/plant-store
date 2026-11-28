<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\UpdateProductUnitStatus;

use App\Application\ProductUnitStatus\Shared\Exception\ProductUnitStatusAlreadyExistsException;
use App\Application\ProductUnitStatus\Shared\Exception\ProductUnitStatusNotFoundException;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use Override;

readonly class UpdateProductUnitStatusService implements UpdateProductUnitStatusUseCase
{
    public function __construct(private ProductUnitStatusRepository $statusRepository) {}

    #[Override]
    public function execute(UpdateProductUnitStatusRequestDto $requestDto): void
    {
        $status = $this->statusRepository->findById($requestDto->id);
        if ($status === null) {
            throw new ProductUnitStatusNotFoundException($requestDto->id);
        }

        $sameName = $this->statusRepository->findByName($requestDto->name);
        if ($sameName !== null && $sameName->id->value !== $status->id->value) {
            throw new ProductUnitStatusAlreadyExistsException($requestDto->name);
        }

        $status->update($requestDto->name, $requestDto->comment);
        $this->statusRepository->update($status);
    }
}
