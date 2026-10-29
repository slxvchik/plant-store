<?php

declare(strict_types=1);

namespace App\Application\Order\CreateOrderForUser;

use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Order\CreateOrder\CreateOrderUseCase;
use App\Application\Order\CreateOrder\Exception\OrderEmptyCartException;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class CreateOrderForUserService implements CreateOrderForUserUseCase
{
    public function __construct(
        private CreateOrderUseCase $createOrderUseCase,
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
    ) {}

    /**
     * @throws CartNotFoundException
     * @throws OrderEmptyCartException
     */
    #[Override]
    public function execute(string $userId): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        if ($cart === null) {
            throw new CartNotFoundException;
        }

        $cartLines = $cart->getCartLines();
        if (count($cartLines) === 0) {
            throw new OrderEmptyCartException;
        }

        $productIdsMap = [];
        foreach ($cartLines as $cartLine) {
            $productIdsMap[$cartLine->productId] = true;
        }

        $products = $this->productRepository->findByIds(array_keys($productIdsMap));
        $productsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
        }

        $expectedSumInKopecks = 0;
        foreach ($cartLines as $cartLine) {
            $expectedSumInKopecks += $productsMap[$cartLine->productId]->getOffer($cartLine->offerId)->price;
        }

        $this->createOrderUseCase->execute($userId, $expectedSumInKopecks);
    }
}
