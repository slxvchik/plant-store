<?php

declare(strict_types=1);

namespace App\Domain\Cart\Models;

use App\Domain\Cart\Exceptions\CartLineNotFoundException;

class Cart
{
    private(set) final string $userId;
    /**
     * @var CartLine[] Map[$productSkuId] => CartLine;
     */
    private(set) array $cartLine;

    /**
     * @param CartLine[] $cartLine
     */
    public function __construct(string $userId, array $cartLine)
    {
        $this->userId = $userId;
        $this->cartLine = $cartLine;
    }

    public function addProduct(string $productSkuId, int $quantity = 1): void
    {
        $cartLine = $this->getCartLineByProduct($productSkuId);
        if ($cartLine === null) {
            $this->cartLine[$productSkuId] = new CartLine($productSkuId, $quantity);
        } else {
            $newQuantity = $cartLine->quantity + $quantity;
            $this->cartLine[$productSkuId] = $cartLine->changeQuantity($newQuantity);
        }
    }

    public function changeProductQuantity(string $productSkuId, int $quantity = 1): void
    {
        $cartLine = $this->getCartLineByProduct($productSkuId);
        if ($cartLine === null) {
            throw new CartLineNotFoundException();
        }
        $this->cartLine[$productSkuId] = $cartLine->changeQuantity($quantity);
    }

    public function removeProduct(string $productSkuId): void
    {
        if (isset($this->cartLine[$productSkuId])) {
            unset($this->cartLine[$productSkuId]);
        }
    }
    
    private function getCartLineByProduct(string $productSkuId): ?CartLine
    {
        return $this->cartLine[$productSkuId] ?? null;
    }
}