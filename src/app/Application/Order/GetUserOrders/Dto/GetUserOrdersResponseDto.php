<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders\Dto;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Media\Model\Image;
use App\Domain\Order\Model\Order;
use App\Domain\Order\Model\OrderLine;
use App\Domain\Order\Model\OrderStatus;
use App\Domain\Product\Model\Product;

final readonly class GetUserOrdersResponseDto
{
    /**
     * @param GetUserOrdersOrderLineResponseDto[] $orderLineResponseDto
     */
    public function __construct(
        public string $id,
        public string $userId,
        public OrderStatus $status,
        public array $orderLineResponseDto,
        public int $orderSumInKopecks
    ) {}

    /**
     * @param Product[] $productsMap $productsMap[productId] => product
     * @param Image[] $imagesMap $imagesMap[imageId] => image
     */
    public static function fromDomain(Order $order, array $productsMap, array $imagesMap): self
    {
        $orderLines = [];
        foreach ($order->orderLines as $orderLine) {
            $product = $productsMap[$orderLine->productId] ?? null;
            $imageId = (!empty($product->imageIds)) ? $product->imageIds[0] : null;
            $image = $imageId !== null ? ($imagesMap[$imageId] ?? null) : null;

            $orderLines[] = new GetUserOrdersOrderLineResponseDto(
                productId: $orderLine->productId,
                productOfferId: $orderLine->productOfferId,
                productName: $product?->name ?? 'Название товара не найдено',
                productImage: $image !== null ? ImageResponseDto::fromDomain($image) : null,
                quantity: $orderLine->quantity,
                unitPriceInKopecks: $orderLine->unitPriceInKopecks
            );
        }
        return new self(
            id: $order->id->value,
            userId: $order->userId,
            status: $order->status,
            orderLineResponseDto: $orderLines,
            orderSumInKopecks: $order->getTotalPrice()
        );
    }
}
