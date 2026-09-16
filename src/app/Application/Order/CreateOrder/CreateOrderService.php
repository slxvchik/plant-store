<?php

declare(strict_types=1);

namespace App\Application\Order\CreateOrder;

use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class CreateOrderService implements CreateOrderUseCase
{
    public function __construct(
        private CartRepository $cartRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository
    ) {}

    #[Override]
    public function execute(string $userId): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        if ($cart === null) {
            throw new CartNotFoundException();
        }
    }
}
