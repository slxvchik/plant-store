<?php

declare(strict_types=1);

namespace App\Http\Requests\Cart;

use App\Application\Cart\GetUserCart\Dto\Request\GetUserCartRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class GetUserCartRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'cartId' => ['sometimes', 'uuid'],
            'userId' => ['sometimes', 'nullable', 'uuid'],
        ];
    }

    public function toDto(): GetUserCartRequestDto
    {
        /** @var array{cartId?: string, userId?: ?string} $data */
        $data = $this->validated();

        return new GetUserCartRequestDto(
            cartId: $data['cartId'] ?? '',
            userId: $data['userId'] ?? null,
        );
    }
}
