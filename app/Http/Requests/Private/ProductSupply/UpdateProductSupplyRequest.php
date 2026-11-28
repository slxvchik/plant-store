<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\ProductSupply;

use App\Application\ProductSupply\UpdateProductSupply\UpdateProductSupplyRequestDto;

class UpdateProductSupplyRequest extends ProductSupplyRequest
{
    public function toDto(string $id): UpdateProductSupplyRequestDto
    {
        return new UpdateProductSupplyRequestDto(...['id' => $id, ...$this->productSupplyData()]);
    }
}
