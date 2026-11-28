<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\Supplier;

use Illuminate\Foundation\Http\FormRequest;

abstract class SupplierRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:32'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }

    /**
     * @return array{name: string, phone: ?string, email: ?string, address: ?string, comment: ?string}
     */
    protected function supplierData(): array
    {
        /** @var array{name: string, phone?: ?string, email?: ?string, address?: ?string, comment?: ?string} $data */
        $data = $this->validated();

        return [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'comment' => $data['comment'] ?? null,
        ];
    }
}
