<?php

declare(strict_types=1);

namespace App\Domain\Cart\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class Cart
{
    public Uuid $id;
    public ?string $userId;
    /**
     * @var array<string, array<string, CartLine>> Map[$productId][$offerId] => CartLine
     */
    private array $cartLines;
    private(set) DateTimeImmutable $updated;

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    private function __construct(Uuid $id, ?string $userId, array $cartLines, DateTimeImmutable $updated)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->cartLines = $cartLines;
        $this->updated = $updated;
    }

    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, ?string $userId): self
    {
        $id = $uuidGeneratorInterface->generate();
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            userId: $userId,
            cartLines: [],
            updated: new DateTimeImmutable()
        );
    }

    /**
     * @param array<string, array<string, CartLine>> $cartLines Map[$productId][$offerId] => CartLine
     */
    public static function fromDb(string $id, ?string $userId, array $cartLines, DateTimeImmutable $updated): self
    {
        return new self(
            id: new Uuid($id),
            userId: $userId,
            cartLines: $cartLines,
            updated: $updated
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
        $this->updated = new DateTimeImmutable();
    }

    public function removeProduct(string $productId, string $offerId): void
    {
        if (isset($this->cartLines[$productId][$offerId])) {
            unset($this->cartLines[$productId][$offerId]);
        }
        $this->updated = new DateTimeImmutable();
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
