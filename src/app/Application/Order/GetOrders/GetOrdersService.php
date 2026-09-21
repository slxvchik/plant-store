<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrders;

use App\Application\Order\GetOrders\Dto\GetOrdersResponseDto;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use App\Domain\User\Repository\UserRepository;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

readonly class GetOrdersService implements GetOrdersUseCase
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository,
        private UserRepository $userRepository,
        private ImageRepository $imageRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page
    {
        $ordersPage = $this->orderRepository->search($pageable, $orderSearchCriteria);

        $warehouse = $this->warehouseRepository->findAll()[0];

        // $userIdsMap[userId]
        $userIdsMap = [];
        // $productIdsMap[productId][offerId]
        $productIdsMap = [];
        foreach ($ordersPage->items as $orderItem) {
            $userIdsMap[$orderItem->userId] = true;
            foreach ($orderItem->orderLines as $orderLine) {
                $productIdsMap[$orderLine->productId] = true;
            }
        }

        $users = $this->userRepository->findByIds(array_keys($userIdsMap));
        // $userMap[userId] => user
        $usersMap = [];
        foreach ($users as $user) {
            $usersMap[$user->id->value] = $user;
        }

        $products = $this->productRepository->findByIds(array_keys($productIdsMap));
        // $productsMap[productId] => product
        $productsMap = [];
        // $imageIdsMap[imageId] => imageUrl
        $imageIdsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
            if ($product->images[0] !== null) {
                $imageIdsMap[$product->id->value] = $product->images[0]->id;
            }
        }

        $images = $this->imageRepository->findByIds(array_keys($imageIdsMap));
        // $imagesMap[imageId] => image
        $imagesMap = [];
        foreach ($images as $image) {
            $imagesMap[$image->id->value] = $image;
        }

        $orderResponseDtos = [];
        foreach ($ordersPage->items as $orderItem) {
            $orderResponseDtos[] = GetOrdersResponseDto::fromDomain(
                order: $orderItem,
                user: $usersMap[$orderItem->userId],
                productsMap: $productsMap,
                imagesMap: $imagesMap,
                warehouseAddress: $warehouse->getAddress()
            );
        }

        return $ordersPage->changeItems($orderResponseDtos);
    }
}
