<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\ProductSupply;

use Illuminate\Foundation\Http\FormRequest;

abstract class ProductSupplyRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'supplierId' => ['required', 'uuid', 'exists:suppliers,id'],
            'offerId' => ['sometimes', 'nullable', 'uuid', 'exists:offers,id'],
            'declaredQuantity' => ['required', 'integer', 'min:1'],
            'actualQuantity' => ['required', 'integer', 'min:0'],
            'unitPurchasePriceInKopecks' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'totalPurchasePriceInKopecks' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'comment' => ['sometimes', 'nullable', 'string'],
            'misGraded' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array{supplierId: string, offerId: ?string, declaredQuantity: int, actualQuantity: int, unitPurchasePriceInKopecks: ?int, totalPurchasePriceInKopecks: ?int, comment: string, misGraded: bool}
     */
    protected function productSupplyData(): array
    {
        /** @var array{supplierId: string, offerId?: ?string, declaredQuantity: int, actualQuantity: int, unitPurchasePriceInKopecks?: ?int, totalPurchasePriceInKopecks?: ?int, comment?: ?string, misGraded: bool} $data */
        $data = $this->validated();

        return [
            'supplierId' => $data['supplierId'],
            'offerId' => $data['offerId'] ?? null,
            'declaredQuantity' => $data['declaredQuantity'],
            'actualQuantity' => $data['actualQuantity'],
            'unitPurchasePriceInKopecks' => $data['unitPurchasePriceInKopecks'] ?? null,
            'totalPurchasePriceInKopecks' => $data['totalPurchasePriceInKopecks'] ?? null,
            'comment' => $data['comment'] ?? '',
            'misGraded' => $data['misGraded'],
        ];
    }
}
