<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnit;

use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitRequestDto;

class StoreProductUnitRequest extends ProductUnitRequest
{
    public function toDto(): CreateProductUnitRequestDto
    {
        return new CreateProductUnitRequestDto(...$this->productUnitData());
    }
}
