<?php

declare(strict_types=1);

namespace App\Http\Requests\Cart;

use App\Application\Cart\DeleteProduct\DeleteProductRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductFromCartRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'uuid'],
        ];
    }

    public function toDto(string $cartId, string $productId, string $offerId): DeleteProductRequestDto
    {
        /** @var array{userId: string} $data */
        $data = $this->validated();

        return new DeleteProductRequestDto(
            userId: $data['userId'],
            cartId: $cartId,
            productId: $productId,
            offerId: $offerId,
        );
    }
}
