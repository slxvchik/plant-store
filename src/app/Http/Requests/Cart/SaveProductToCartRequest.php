<?php

declare(strict_types=1);

namespace App\Http\Requests\Cart;

use App\Application\Cart\SaveProduct\Dto\SaveProductRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class SaveProductToCartRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'userId' => ['sometimes', 'nullable', 'uuid'],
            'productId' => ['required', 'uuid', 'exists:products,id'],
            'offerId' => ['required', 'uuid', 'exists:offers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function toDto(string $cartId): SaveProductRequestDto
    {
        /** @var array{userId?: ?string, productId: string, offerId: string, quantity: int} $data */
        $data = $this->validated();

        return new SaveProductRequestDto(
            cartId: $cartId,
            userId: $data['userId'] ?? null,
            productId: $data['productId'],
            offerId: $data['offerId'],
            quantity: $data['quantity'],
        );
    }
}
