<?php

declare(strict_types=1);

namespace App\Application\Cart\SaveProduct;

use App\Application\Cart\SaveProduct\Dto\SaveProductRequestDto;
use App\Application\Cart\SaveProduct\Dto\SaveProductResponseDto;
use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Cart\Shared\Exception\CartUserAccessDeniedException;
use App\Application\Cart\Shared\Exception\CartUserNotFoundException;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class SaveProductService implements SaveProductUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private CartRepository $cartRepository,
        private ProductRepository $productRepository
    ) {}

    #[Override]
    public function execute(SaveProductRequestDto $saveProductRequestDto): SaveProductResponseDto
    {
        $cart = $this->cartRepository->findById($saveProductRequestDto->cartId);
        if ($cart === null) {
            throw new CartNotFoundException();
        }

        if ($cart->userId !== null && $cart->userId !== $saveProductRequestDto->userId) {
            throw new CartUserAccessDeniedException();
        } else if ($cart->userId === null && $cart->userId !== $saveProductRequestDto->userId) {
            $user = $this->userRepository->findById($saveProductRequestDto->userId);
            if ($user === null) {
                throw new CartUserNotFoundException();
            }
            $cart->userId = $user->id->value;
        }

        $product = $this->productRepository->findById($saveProductRequestDto->productId);
        if ($product === null) {
            throw new ProductNotFoundException();
        }
        $offer = $product->getOffer($saveProductRequestDto->offerId);

        $availableQuantity = $product->getOfferAvailableQuantity($offer->id->value);
        $quantity = $saveProductRequestDto->quantity;
        if ($quantity >= $availableQuantity) {
            $quantity = $availableQuantity;
        }

        $cart->saveProduct(
            productId: $product->id->value,
            offerId: $offer->id->value,
            quantity: $quantity
        );

        $this->cartRepository->update($cart);

        return new SaveProductResponseDto(
            productId: $product->id->value,
            offerId: $offer->id->value,
            quantity: $quantity,
            availableQuantity: $availableQuantity
        );
    }
}
