<?php

declare(strict_types=1);

namespace App\Domain\Cart\Model;

use App\Domain\Cart\Exception\CartLineNotFoundException;

class Cart
{
    public final string $userId;
    /**
     * @var array<string, array<string, CartLine>> Map[$productId][$offerId] => CartLine
     */
    private array $cartLines;

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    private function __construct(string $userId, array $cartLines)
    {
        $this->userId = $userId;
        $this->cartLines = $cartLines;
    }

    public static function createNew(string $userId): self
    {
        return new self(
            userId: $userId,
            cartLines: []
        );
    }

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    public static function fromDb(string $userId, array $cartLines): self
    {
        return new self(
            userId: $userId,
            cartLines: $cartLines
        );
    }

    public function addProduct(string $productId, string $offerId, int $quantity = 1): void
    {
        $cartLine = $this->getCartLineByProduct($productId, $offerId);
        if ($cartLine === null) {
            $this->cartLines[$productId][$offerId] = new CartLine($productId, $offerId, $quantity);
        } else {
            $newQuantity = $cartLine->quantity + $quantity;
            $this->cartLines[$productId][$offerId] = $cartLine->changeQuantity($newQuantity);
        }
    }

    public function changeProductQuantity(string $productId, string $offerId, int $quantity = 1): void
    {
        $cartLine = $this->getCartLineByProduct($productId, $offerId);
        if ($cartLine === null) {
            throw new CartLineNotFoundException();
        }
        $this->cartLines[$offerId] = $cartLine->changeQuantity($quantity);
    }

    public function removeProduct(string $productId, string $offerId): void
    {
        if (isset($this->cartLines[$productId][$offerId])) {
            unset($this->cartLines[$productId][$offerId]);
        }
    }

    private function getCartLineByProduct(string $productId, string $offerId): ?CartLine
    {
        return $this->cartLines[$productId][$offerId] ?? null;
    }

    /**
     * @return CartLine[]
     */
    public function getCartLines(): array
    {
        $cartLines = [];
        foreach ($this->cartLines as $productId => $offerIds) {
            foreach ($offerIds as $offerId => $cartLine) {
                $cartLines[] = $cartLine;
            }
        }
        return $cartLines;
    }
}
