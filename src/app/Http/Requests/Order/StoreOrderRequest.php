<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'uuid', 'exists:users,id'],
        ];
    }

    public function toUserId(): string
    {
        /** @var array{userId: string} $data */
        $data = $this->validated();

        return $data['userId'];
    }
}
