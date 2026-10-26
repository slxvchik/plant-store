<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class WarehouseRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:18'],
        ];
    }

    /**
     * @return array{address: string, phoneNumber: ?string}
     */
    protected function warehouseData(): array
    {
        /** @var array{address: string, phone?: ?string} $data */
        $data = $this->validated();

        return [
            'address' => $data['address'],
            'phoneNumber' => $data['phone'] ?? null,
        ];
    }
}
