<?php

declare(strict_types=1);

namespace App\Application\Order\CreateOrder;

use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Order\CreateOrder\Exception\OrderEmptyCartException;
use App\Application\Order\CreateOrder\Exception\OrderInvalidSumExpectationException;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Order\Model\Order;
use App\Domain\Order\Model\OrderLine;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class CreateOrderService implements CreateOrderUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private CartRepository $cartRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository,
        private WarehouseRepository $warehouseRepository
    ) {}

    #[Override]
    public function execute(string $userId, int $expectedSumInKopecks): void
    {
        $cart = $this->cartRepository->findByUserId($userId);
        if ($cart === null) {
            throw new CartNotFoundException();
        }

        $cartLines = $cart->getCartLines();

        if (count($cartLines) === 0) {
            throw new OrderEmptyCartException();
        }

        // now only with one warehouse with simple logic
        $warehouses = $this->warehouseRepository->findAll();
        $warehouse = $warehouses[0];

        // productIds[productId][offerIds]
        $productIds = [];
        foreach ($cartLines as $cartLine) {
            $productIds[$cartLine->productId][] = $cartLine->offerId;
        }

        $actualProducts = $this->productRepository->findByIds($productIds);
        $actualProductsMap = [];
        foreach ($actualProducts as $actualProduct) {
            $actualProductsMap[$actualProduct->id->value] = $actualProduct;
        }

        $actualSumInKopecks = 0;
        $orderLines = [];
        foreach ($cartLines as $cartLine) {
            $product = $actualProductsMap[$cartLine->productId];
            $offer = $product->getOffer($cartLine->offerId);
            $offer->reserve($warehouse->id->value, $cartLine->quantity);

            $actualSumInKopecks += $offer->price;

            $orderLines[] = new OrderLine(
                productId: $product->id->value,
                productOfferId: $offer->id->value,
                quantity: $cartLine->quantity,
                unitPriceInKopecks: $offer->price
            );
        }

        // comparing expected prices and current prices
        if ($actualSumInKopecks !== $expectedSumInKopecks) {
            throw new OrderInvalidSumExpectationException();
        }

        $order = Order::createNew(
            uuidGeneratorInterface: $this->uuidGeneratorInterface,
            userId: $userId,
            orderLines: $orderLines
        );

        foreach ($actualProductsMap as $product) {
            $this->productRepository->update($product);
        }

        $this->orderRepository->create($order);
    }
}
