<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnit;

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
            'qrCode' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array{productSupplyId: ?string, offerId: ?string, warehouseId: string, reserved: bool, sowingDate: ?DateTimeImmutable, productUnitStatusId: string, comments: string, qrCode: ?string}
     */
    protected function productUnitData(): array
    {
        /** @var array{productSupplyId?: ?string, offerId?: ?string, warehouseId: string, reserved: bool, sowingDate?: ?string, productUnitStatusId: string, comments?: ?string, qrCode?: ?string} $data */
        $data = $this->validated();

        return [
            'productSupplyId' => $data['productSupplyId'] ?? null,
            'offerId' => $data['offerId'] ?? null,
            'warehouseId' => $data['warehouseId'],
            'reserved' => $data['reserved'],
            'sowingDate' => isset($data['sowingDate']) ? new DateTimeImmutable($data['sowingDate']) : null,
            'productUnitStatusId' => $data['productUnitStatusId'],
            'comments' => $data['comments'] ?? '',
            'qrCode' => $data['qrCode'] ?? null,
        ];
    }
}
