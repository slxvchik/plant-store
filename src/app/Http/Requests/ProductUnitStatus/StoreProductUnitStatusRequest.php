<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnitStatus;

use App\Application\ProductUnitStatus\CreateProductUnitStatus\CreateProductUnitStatusRequestDto;

class StoreProductUnitStatusRequest extends ProductUnitStatusRequest
{
    public function toDto(): CreateProductUnitStatusRequestDto
    {
        return new CreateProductUnitStatusRequestDto(...$this->statusData());
    }
}
