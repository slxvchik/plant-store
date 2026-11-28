<?php

declare(strict_types=1);

namespace App\Application\Supplier\GetSuppliers;

use App\Application\Supplier\Shared\Dto\Response\SupplierResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Supplier\SupplierRepository;
use Override;

readonly class GetSuppliersService implements GetSuppliersUseCase
{
    public function __construct(private SupplierRepository $supplierRepository) {}

    #[Override]
    public function execute(Pageable $pageable, ?string $search = null): Page
    {
        $page = $this->supplierRepository->findPage($pageable, $search);
        $suppliers = array_map(SupplierResponseDto::fromDomain(...), $page->items);

        return $page->changeItems($suppliers);
    }
}
