<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\DeleteProductUnitStatus;

use App\Application\ProductUnitStatus\Shared\Exception\ProductUnitStatusNotFoundException;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use Override;

readonly class DeleteProductUnitStatusService implements DeleteProductUnitStatusUseCase
{
    public function __construct(private ProductUnitStatusRepository $statusRepository) {}

    #[Override]
    public function execute(string $id): void
    {
        if ($this->statusRepository->findById($id) === null) {
            throw new ProductUnitStatusNotFoundException($id);
        }

        $this->statusRepository->delete($id);
    }
}
