<?php

declare(strict_types=1);

namespace App\Application\Cart\CreateCart;

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
    public function execute(UuidGeneratorInterface $uuidGeneratorInterface, string $userId): string
    {
        throw new \Exception('Not implemented');
    }
}
