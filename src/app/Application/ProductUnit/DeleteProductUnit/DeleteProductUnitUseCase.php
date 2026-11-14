<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\DeleteProductUnit;

interface DeleteProductUnitUseCase
{
    public function execute(string $id): void;
}
