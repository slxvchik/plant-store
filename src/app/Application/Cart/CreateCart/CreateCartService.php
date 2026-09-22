<?php

declare(strict_types=1);

namespace App\Application\Cart\CreateCart;

use App\Application\Cart\Shared\Exception\CartAlreadyExistsException;
use App\Application\User\Shared\Exception\UserNotFoundException;
use App\Domain\Cart\Model\Cart;
use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class CreateCartService implements CreateCartUseCase
{
    public function __construct(
        private CartRepository $cartRepository,
        private UserRepository $userRepository
    ) {}

    #[Override]
    public function execute(UuidGeneratorInterface $uuidGeneratorInterface, ?string $userId): string
    {
        if ($userId !== null) {
            $user = $this->userRepository->findById($userId);
            if ($user === null) {
                throw new UserNotFoundException();
            }
            $cart = $this->cartRepository->findByUserId($userId);
            if ($cart !== null) {
                throw new CartAlreadyExistsException();
            }
        }

        $newCart = Cart::createNew(
            uuidGeneratorInterface: $uuidGeneratorInterface,
            userId: $userId
        );

        return $this->cartRepository->create($newCart);
    }
}
