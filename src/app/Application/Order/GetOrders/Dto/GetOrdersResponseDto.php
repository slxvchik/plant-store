<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrders\Dto;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Media\Model\Image;
use App\Domain\Order\Model\Order;
use App\Domain\Order\Model\OrderStatus;
use App\Domain\Product\Model\Product;
use App\Domain\User\Model\User;

final readonly class GetOrdersResponseDto
{
    /**
     * @param GetOrdersOrderLineResponseDto[] $orderLineResponseDto
     */
    public function __construct(
        public string $id,
        public OrderStatus $status,
        public array $orderLineResponseDto,
        public int $orderSumInKopecks,
        public GetOrdersUserResponseDto $user
    ) {}

    /**
     * @param array<string, Product> $productsMap Map[productId] => product
     * @param array<string, Image> $imagesMap Map[imageId] => image
     */
    public static function fromDomain(Order $order, User $user, array $productsMap, array $imagesMap, string $warehouseAddress): self
    {
        $orderLinesDtos = [];
        foreach ($order->orderLines as $orderLine) {
            $product = $productsMap[$orderLine->productId] ?? null;
            $offer = $product?->getOffer($orderLine->productOfferId);
            $imageId = (!empty($product->imageIds)) ? $product->imageIds[0] : null;
            $imageModel = $imageId ? ($imagesMap[$imageId] ?? null) : null;
            $imageDto = $imageModel ? ImageResponseDto::fromDomain($imageModel) : null;

            $orderLinesDtos[] = new GetOrdersOrderLineResponseDto(
                productId: $orderLine->productId,
                offerId: $orderLine->productOfferId,
                imageResponseDto: $imageDto,
                productName: $offer?->name ?? 'Товар не найден',
                quantity: $orderLine->quantity,
                unitPriceInKopecks: $orderLine->unitPriceInKopecks,
                warehouseAddress: $warehouseAddress
            );
        }

        $userDto = new GetOrdersUserResponseDto(
            id: $user->id->value,
            firstName: $user->firstName,
            lastName: $user->lastName,
            email: $user->email,
            phone: $user->phone,
        );

        return new self(
            id: $order->id->value,
            status: $order->status,
            orderLineResponseDto: $orderLinesDtos,
            orderSumInKopecks: $order->getTotalPrice(),
            user: $userDto
        );
    }
}
