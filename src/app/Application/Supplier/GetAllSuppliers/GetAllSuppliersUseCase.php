<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetAllSuppliers;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;

interface GetAllSuppliersUseCase
{
    /**
     * @return SupplierResponseDto[]
     */
    public function execute(): array;
}
