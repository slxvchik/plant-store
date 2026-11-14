<?php

declare(strict_types=1);

namespace App\Http\Requests\ProductUnitStatus;

use Illuminate\Foundation\Http\FormRequest;

abstract class ProductUnitStatusRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }

    /**
     * @return array{name: string, comment: ?string}
     */
    protected function statusData(): array
    {
        /** @var array{name: string, comment?: ?string} $data */
        $data = $this->validated();

        return ['name' => $data['name'], 'comment' => $data['comment'] ?? null];
    }
}
