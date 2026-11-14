<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetSuppliers;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetSuppliersUseCase
{
    /**
     * @return Page<SupplierResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
