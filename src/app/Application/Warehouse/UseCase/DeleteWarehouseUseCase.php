<?php

declare(strict_types=1);

namespace App\Application\Warehouse\UseCase;

interface DeleteWarehouseUseCase
{
    public function execute(string $id): void;
}