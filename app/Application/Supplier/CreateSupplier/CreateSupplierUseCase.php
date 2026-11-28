<?php

declare(strict_types=1);

namespace App\Application\Supplier\CreateSupplier;

interface CreateSupplierUseCase
{
    public function execute(CreateSupplierRequestDto $createSupplierRequestDto): string;
}
