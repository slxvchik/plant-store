<?php

declare(strict_types=1);

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'userId' => ['sometimes', 'nullable', 'uuid', 'exists:users,id'],
        ];
    }

    public function toUserId(): ?string
    {
        /** @var array{userId?: ?string} $data */
        $data = $this->validated();

        return $data['userId'] ?? null;
    }
}
