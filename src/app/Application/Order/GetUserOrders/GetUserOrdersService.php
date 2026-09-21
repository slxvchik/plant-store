<?php

namespace App\Application\Order\GetUserOrders;

use App\Application\Order\GetUserOrders\Dto\GetUserOrdersResponseDto;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Model\Order;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

final readonly class GetUserOrdersService implements GetUserOrdersUseCase
{
    public function __construct(
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository,
        private ImageRepository $imageRepository
    ) {}

    public function execute(string $userId, Pageable $pageable): Page
    {
        $page = $this->orderRepository->search(
            pageable: $pageable,
            orderSearchCriteria: new OrderSearchCriteria(userId: $userId)
        );

        // $productIds[productId] => bool
        $productIdsMap = [];
        foreach ($page->items as $order) {
            foreach ($order->orderLines as $orderLine) {
                $productIdsMap[$orderLine->productId] = true;
            }
        }

        $products = $this->productRepository->findByIds(array_keys($productIdsMap));
        // $productsMap[productId] => product
        $productsMap = [];
        // $imageIds[imageId] => image
        $imageIdsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
            if (!empty($product->imageIds)) {
                $imageIdsMap[$product->imageIds[0]] = true;
            }
        }

        $images = $this->imageRepository->findByIds(array_keys($imageIdsMap));
        // $imagesMap[imageId] => image
        $imagesMap = [];
        foreach ($images as $image) {
            $imagesMap[$image->id->value] = $image;
        }

        $orderDtos = [];
        foreach ($page->items as $order) {
            $orderDtos[] = GetUserOrdersResponseDto::fromDomain(
                order: $order,
                productsMap: $productsMap,
                imagesMap: $imagesMap
            );
        }

        return $page->changeItems($orderDtos);
    }
}
