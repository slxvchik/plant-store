<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetSupplier;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;

interface GetSupplierUseCase
{
    public function execute(string $id): SupplierResponseDto;
}
