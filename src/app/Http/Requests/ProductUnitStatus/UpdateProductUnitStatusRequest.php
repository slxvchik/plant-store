<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnitStatus;

use App\Application\ProductUnitStatus\UpdateProductUnitStatus\UpdateProductUnitStatusRequestDto;

class UpdateProductUnitStatusRequest extends ProductUnitStatusRequest
{
    public function toDto(string $id): UpdateProductUnitStatusRequestDto
    {
        return new UpdateProductUnitStatusRequestDto(...['id' => $id, ...$this->statusData()]);
    }
}
