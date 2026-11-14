<?php

declare(strict_types=1);

namespace App\Http\Requests\Supplier;

use App\Application\Supplier\CreateSupplier\CreateSupplierRequestDto;

class StoreSupplierRequest extends SupplierRequest
{
    public function toDto(): CreateSupplierRequestDto
    {
        return new CreateSupplierRequestDto(...$this->supplierData());
    }
}
