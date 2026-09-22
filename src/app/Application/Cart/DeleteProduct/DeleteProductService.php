<?php

declare(strict_types=1);

namespace App\Application\Cart\DeleteProduct;

use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Cart\Shared\Exception\CartUserAccessDeniedException;
use App\Application\Cart\Shared\Exception\CartUserNotFoundException;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class DeleteProductService implements DeleteProductUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private CartRepository $cartRepository
    ) {}

    #[Override]
    public function execute(DeleteProductRequestDto $deleteProductRequestDto): void
    {
        $cart = $this->cartRepository->findById($deleteProductRequestDto->cartId);
        if ($cart === null) {
            throw new CartNotFoundException();
        }

        if ($cart->userId !== null && $cart->userId !== $deleteProductRequestDto->userId) {
            throw new CartUserAccessDeniedException();
        } else if ($cart->userId === null && $cart->userId !== $deleteProductRequestDto->userId) {
            $user = $this->userRepository->findById($deleteProductRequestDto->userId);
            if ($user === null) {
                throw new CartUserNotFoundException();
            }
            $cart->userId = $user->id->value;
        }

        $cart->removeProduct(
            productId: $deleteProductRequestDto->productId,
            offerId: $deleteProductRequestDto->offerId
        );

        $this->cartRepository->update($cart);
    }
}
