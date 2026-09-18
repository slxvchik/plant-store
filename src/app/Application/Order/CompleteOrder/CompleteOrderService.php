<?php

declare(strict_types=1);

namespace App\Application\Order\CompleteOrder;

use App\Application\Order\Shared\Exception\OrderNotFoundException;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class CompleteOrderService implements CompleteOrderUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $order = $this->orderRepository->findById($id);
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
            $offer = $product->getOffer($orderLine->productOfferId);
            $offer->ship($warehouseId, $orderLine->quantity);
        }

        foreach ($productsMap as $product) {
            $this->productRepository->update($product);
        }
    }
}
