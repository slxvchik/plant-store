<?php

declare(strict_types=1);

namespace App\Application\Order\CancelOrder;

use App\Application\Order\Shared\Exception\OrderNotFoundException;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class CancelOrderService implements CancelOrderUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository
    ) {}

    #[Override]
    public function execute(string $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);
        if ($order === null) {
            throw new OrderNotFoundException();
        }

        $warehouses = $this->warehouseRepository->findAll();
        $warehouseId = $warehouses[0]->id->value;

        $productIds = [];
        foreach ($order->orderLines as $orderLine) {
            $productIds[] = $orderLine->productId;
        }

        $products = $this->productRepository->findByIds($productIds);
        $productsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
        }

        foreach ($order->orderLines as $orderLine) {
            $product = $productsMap[$orderLine->productId];
            $product->getOffer($orderLine->productOfferId)->refund($warehouseId, $orderLine->quantity);
        }

        foreach ($productsMap as $product) {
            $this->productRepository->update($product);
        }

        $order->cancel();

        $this->orderRepository->update($order);
    }
}
