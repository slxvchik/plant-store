<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Cart\Model\Cart;
use App\Domain\Cart\Repository\CartRepository;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\DB;
use Override;

class CartRepositoryImpl implements CartRepository
{
    #[Override]
    public function create(Cart $cart): string
    {
        $model = new CartModel;
        $model->id = $cart->id->value;
        $model->user_id = $cart->userId !== null ? (int) $cart->userId : null;
        $model->save();

        $this->syncLines($cart);

        return $cart->id->value;
    }

    #[Override]
    public function update(Cart $cart): void
    {
        $model = CartModel::findOrFail($cart->id->value);
        $model->user_id = $cart->userId !== null ? (int) $cart->userId : null;
        $model->save();

        $this->syncLines($cart);
    }

    #[Override]
    public function findById(string $id): ?Cart
    {
        return CartModel::find($id)?->toDomain();
    }

    #[Override]
    public function findByUserId(string $userId): ?Cart
    {
        return CartModel::firstWhere('user_id', $userId)?->toDomain();
    }

    private function syncLines(Cart $cart): void
    {
        DB::table('cart_lines')->where('cart_id', $cart->id->value)->delete();

        foreach ($cart->getCartLines() as $cartLine) {
            DB::table('cart_lines')->insert([
                'cart_id' => $cart->id->value,
                'product_id' => $cartLine->productId,
                'offer_id' => $cartLine->offerId,
                'quantity' => $cartLine->quantity,
            ]);
        }
    }
}
