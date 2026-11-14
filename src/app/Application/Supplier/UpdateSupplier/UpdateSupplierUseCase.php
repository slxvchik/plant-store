<?php

declare(strict_types=1);

namespace App\Application\Supplier\UpdateSupplier;

interface UpdateSupplierUseCase
{
    public function execute(UpdateSupplierRequestDto $updateSupplierRequestDto): void;
}
