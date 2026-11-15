<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnit;

use App\Domain\ProductUnit\ProductUnitCriteria;
use App\Http\Requests\PaginationRequest;

class ProductUnitIndexRequest extends PaginationRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'offerId' => ['sometimes', 'nullable', 'uuid'],
            'warehouseId' => ['sometimes', 'nullable', 'uuid'],
            'productUnitStatusId' => ['sometimes', 'nullable', 'uuid'],
            'productSupplyId' => ['sometimes', 'nullable', 'uuid'],
        ]);
    }

    public function toCriteria(): ProductUnitCriteria
    {
        /** @var array{offerId?: ?string, warehouseId?: ?string, productUnitStatusId?: ?string, productSupplyId?: ?string} $data */
        $data = $this->validated();

        return new ProductUnitCriteria(
            offerId: $data['offerId'] ?? null,
            warehouseId: $data['warehouseId'] ?? null,
            productUnitStatusId: $data['productUnitStatusId'] ?? null,
            productSupplyId: $data['productSupplyId'] ?? null,
        );
    }

    /**
     * @return array{offerId: ?string, warehouseId: ?string, productUnitStatusId: ?string, productSupplyId: ?string}
     */
    public function filters(): array
    {
        $criteria = $this->toCriteria();

        return [
            'offerId' => $criteria->offerId,
            'warehouseId' => $criteria->warehouseId,
            'productUnitStatusId' => $criteria->productUnitStatusId,
            'productSupplyId' => $criteria->productSupplyId,
        ];
    }
}
