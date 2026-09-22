<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart;

use App\Application\Cart\GetUserCart\Dto\Request\GetUserCartRequestDto;
use App\Application\Cart\GetUserCart\Dto\Response\GetUserCartCartLineResponseDto;
use App\Application\Cart\GetUserCart\Dto\Response\GetUserCartProductResponseDto;
use App\Application\Cart\GetUserCart\Dto\Response\GetUserCartResponseDto;
use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Cart\Shared\Exception\CartUserAccessDeniedException;
use App\Application\Cart\Shared\Exception\CartUserNotFoundException;
use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class GetUserCartService implements GetUserCartUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private ImageRepository $imageRepository
    ) {}

    #[Override]
    public function execute(GetUserCartRequestDto $getUserCartRequestDto): GetUserCartResponseDto
    {
        $cart = $this->cartRepository->findById($getUserCartRequestDto->cartId);
        if ($cart === null) {
            throw new CartNotFoundException();
        }

        if ($cart->userId !== null && $cart->userId !== $getUserCartRequestDto->userId) {
            throw new CartUserAccessDeniedException();
        } else if ($cart->userId === null && $cart->userId !== $getUserCartRequestDto->userId) {
            $user = $this->userRepository->findById($getUserCartRequestDto->userId);
            if ($user === null) {
                throw new CartUserNotFoundException();
            }
            $cart->userId = $user->id->value;
        }

        $cartLines = $cart->getCartLines();

        // $productIdsMap[productId] => bool
        $productIdsMap = [];
        foreach ($cartLines as $cartLine) {
            $productIdsMap[$cartLine->productId] = true;
        }

        $products = $this->productRepository->findByIds(array_keys($productIdsMap));
        // $productsMap[productId] => product
        $productsMap = [];
        // $imageIdsMap[$imageId] => bool
        $imageIdsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id->value] = $product;
            foreach ($product->imageIds as $imageId) {
                $imageIdsMap[$imageId] = true;
            }
        }

        $images = $this->imageRepository->findByIds(array_keys($imageIdsMap));
        // $imagesMap[imageId] => image
        $imagesMap = [];
        foreach ($images as $image) {
            $imagesMap[$image->id->value] = $image;
        }

        $cartLineResponseDtos = [];
        foreach ($cartLines as $cartLine) {
            $product = $productsMap[$cartLine->productId];

            if ($product === null) {
                continue;
            }

            $images = [];
            foreach ($product->imageIds as $imageId) {
                if ($imagesMap[$imageId] !== null) {
                    $images[] = ImageResponseDto::fromDomain($imagesMap[$imageId]);
                }
            }

            if (!$product->offerExists($cartLine->offerId)) {
                continue;
            }

            $offer = $product->getOffer($cartLine->offerId);

            $cartLineResponseDtos[] = new GetUserCartCartLineResponseDto(
                product: GetUserCartProductResponseDto::fromDomain(
                    product: $product,
                    offer: $offer,
                    images: $images
                ),
                quantity: $cartLine->quantity,
                availableQuantity: $offer->getAvailableQuantity()
            );
        }

        return new GetUserCartResponseDto(
            cartId: $cart->id->value,
            userId: $cart->userId,
            cartLines: $cartLineResponseDtos
        );
    }
}
