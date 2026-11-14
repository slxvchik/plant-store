<?php

declare(strict_types=1);

namespace App\Http\Requests\Supplier;

use App\Application\Supplier\UpdateSupplier\UpdateSupplierRequestDto;

class UpdateSupplierRequest extends SupplierRequest
{
    public function toDto(string $id): UpdateSupplierRequestDto
    {
        return new UpdateSupplierRequestDto(...['id' => $id, ...$this->supplierData()]);
    }
}
