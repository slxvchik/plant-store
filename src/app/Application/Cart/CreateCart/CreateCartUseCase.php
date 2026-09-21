<?php

declare(strict_types=1);

namespace App\Application\Cart\CreateCart;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;

interface CreateCartUseCase
{
    /**
     * @return string cartId
     */
    public function execute(UuidGeneratorInterface $uuidGeneratorInterface, string $userId): string;
}
