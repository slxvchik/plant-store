<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\ProductUnit;

use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProductUnitRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'productSupplyId' => ['sometimes', 'nullable', 'uuid', 'exists:product_supplies,id'],
            'offerId' => ['sometimes', 'nullable', 'uuid', 'exists:offers,id'],
            'warehouseId' => ['required', 'uuid', 'exists:warehouses,id'],
            'reserved' => ['required', 'boolean'],
            'sowingDate' => ['sometimes', 'nullable', 'date'],
            'productUnitStatusId' => ['required', 'uuid', 'exists:product_unit_statuses,id'],
            'comments' => ['sometimes', 'nullable', 'string'],
        ];
    }

    protected function productUnitData(): array
    {
        /** @var array{productSupplyId?: ?string, offerId?: ?string, warehouseId: string, reserved: bool, sowingDate?: ?string, productUnitStatusId: string, comments?: ?string} $data */
        $data = $this->validated();

        return [
            'productSupplyId' => $data['productSupplyId'] ?? null,
            'offerId' => $data['offerId'] ?? null,
            'warehouseId' => $data['warehouseId'],
            'reserved' => $data['reserved'],
            'sowingDate' => isset($data['sowingDate']) ? new DateTimeImmutable($data['sowingDate']) : null,
            'productUnitStatusId' => $data['productUnitStatusId'],
            'comments' => $data['comments'] ?? '',
        ];
    }
}
