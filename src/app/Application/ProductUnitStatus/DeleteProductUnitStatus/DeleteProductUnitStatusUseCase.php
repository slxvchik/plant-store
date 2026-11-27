<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\DeleteProductUnitStatus;

interface DeleteProductUnitStatusUseCase
{
    public function execute(string $id): void;
}
