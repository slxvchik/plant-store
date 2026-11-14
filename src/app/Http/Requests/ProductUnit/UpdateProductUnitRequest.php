<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnit;

use App\Application\ProductUnit\UpdateProductUnit\UpdateProductUnitRequestDto;

class UpdateProductUnitRequest extends ProductUnitRequest
{
    public function toDto(string $id): UpdateProductUnitRequestDto
    {
        return new UpdateProductUnitRequestDto(...['id' => $id, ...$this->productUnitData()]);
    }
}
