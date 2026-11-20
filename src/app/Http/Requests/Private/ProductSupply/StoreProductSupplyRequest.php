<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\ProductSupply;

use App\Application\ProductSupply\CreateProductSupply\CreateProductSupplyRequestDto;

class StoreProductSupplyRequest extends ProductSupplyRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'warehouseId' => ['required', 'uuid', 'exists:warehouses,id'],
            'initialProductUnitStatusId' => ['required', 'uuid', 'exists:product_unit_statuses,id'],
        ]);
    }

    public function toDto(): CreateProductSupplyRequestDto
    {
        /** @var array{warehouseId: string, initialProductUnitStatusId: string} $data */
        $data = $this->validated();

        return new CreateProductSupplyRequestDto(...[
            ...$this->productSupplyData(),
            'warehouseId' => $data['warehouseId'],
            'initialProductUnitStatusId' => $data['initialProductUnitStatusId'],
        ]);
    }
}
