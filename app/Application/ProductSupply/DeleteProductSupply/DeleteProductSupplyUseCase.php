<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\DeleteProductSupply;

interface DeleteProductSupplyUseCase
{
    public function execute(string $id): void;
}
