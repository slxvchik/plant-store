<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\ProductUnit;

use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsRequestDto;
use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

class BatchCreateProductUnitsRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'offerId' => ['required', 'uuid', 'exists:offers,id'],
            'warehouseId' => ['required', 'uuid', 'exists:warehouses,id'],
            'productUnitStatusId' => ['required', 'uuid', 'exists:product_unit_statuses,id'],
            'productSupplyId' => ['sometimes', 'nullable', 'uuid', 'exists:product_supplies,id'],
            'sowingDate' => ['sometimes', 'nullable', 'date'],
            'comments' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function toDto(): BatchCreateProductUnitsRequestDto
    {
        /** @var array{quantity: int, offerId: string, warehouseId: string, productUnitStatusId: string, productSupplyId?: ?string, sowingDate?: ?string, comments?: ?string} $data */
        $data = $this->validated();

        return new BatchCreateProductUnitsRequestDto(
            quantity: $data['quantity'],
            offerId: $data['offerId'],
            warehouseId: $data['warehouseId'],
            productUnitStatusId: $data['productUnitStatusId'],
            productSupplyId: $data['productSupplyId'] ?? null,
            sowingDate: isset($data['sowingDate']) ? new DateTimeImmutable($data['sowingDate']) : null,
            comments: $data['comments'] ?? '',
        );
    }
}
