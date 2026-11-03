<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrder;

use App\Application\Order\GetOrders\Dto\GetOrdersResponseDto;
use App\Application\Order\Shared\Exception\OrderNotFoundException;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\User\Repository\UserRepository;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class GetOrderService implements GetOrderUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository,
        private UserRepository $userRepository,
        private ImageRepository $imageRepository,
    ) {}

    /**
     * @throws OrderNotFoundException
     */
    #[Override]
    public function execute(string $id): GetOrdersResponseDto
    {
        $order = $this->orderRepository->findById($id);
        if ($order === null) {
            throw new OrderNotFoundException;
        }

        $warehouse = $this->warehouseRepository->findAll()[0];

        $productIdsMap = [];
        foreach ($order->orderLines as $orderLine) {
            $productIdsMap[$orderLine->productId] = true;
        }

        $products = $this->productRepository->findByIds(array_keys($productIdsMap));
        $productsMap = [];
        $imageIdsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
            if (! empty($product->imageIds)) {
                $imageIdsMap[$product->imageIds[0]->id] = true;
            }
        }

        $imagesMap = [];
        foreach ($this->imageRepository->findByIds(array_keys($imageIdsMap)) as $image) {
            $imagesMap[$image->id->value] = $image;
        }

        $user = $this->userRepository->findById($order->userId);
        if ($user === null) {
            throw new OrderNotFoundException;
        }

        return GetOrdersResponseDto::fromDomain(
            order: $order,
            user: $user,
            productsMap: $productsMap,
            imagesMap: $imagesMap,
            warehouseAddress: $warehouse->address,
        );
    }
}
