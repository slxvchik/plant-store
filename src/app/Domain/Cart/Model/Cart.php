<?php

declare(strict_types=1);

namespace App\Domain\Cart\Model;

class Cart
{
    public ?string $userId;
    public ?string $anonymousId;
    /**
     * @var array<string, array<string, CartLine>> Map[$productId][$offerId] => CartLine
     */
    private array $cartLines;

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    private function __construct(?string $userId, ?string $anonymousId, array $cartLines)
    {
        $this->userId = $userId;
        $this->anonymousId = $anonymousId;
        $this->cartLines = $cartLines;
    }

    public static function createNew(?string $userId, ?string $anonymousId): self
    {
        return new self(
            userId: $userId,
            anonymousId: $anonymousId,
            cartLines: []
        );
    }

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    public static function fromDb(?string $userId, ?string $anonymousId, array $cartLines): self
    {
        return new self(
            userId: $userId,
            anonymousId: $anonymousId,
            cartLines: $cartLines
        );
    }

    public function saveProduct(string $productId, string $offerId, int $quantity = 1): void
    {
        $cartLine = $this->getCartLine($productId, $offerId);
        if ($cartLine === null) {
            $this->cartLines[$productId][$offerId] = new CartLine($productId, $offerId, $quantity);
        } else {
            $newQuantity = $cartLine->quantity + $quantity;
            $this->cartLines[$productId][$offerId] = $cartLine->changeQuantity($newQuantity);
        }
    }

    public function removeProduct(string $productId, string $offerId): void
    {
        if (isset($this->cartLines[$productId][$offerId])) {
            unset($this->cartLines[$productId][$offerId]);
        }
    }

    private function getCartLine(string $productId, string $offerId): ?CartLine
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
