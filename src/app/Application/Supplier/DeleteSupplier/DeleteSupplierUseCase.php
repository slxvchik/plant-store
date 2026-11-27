<?php

declare(strict_types=1);

namespace App\Application\Supplier\DeleteSupplier;

interface DeleteSupplierUseCase
{
    public function execute(string $id): void;
}
