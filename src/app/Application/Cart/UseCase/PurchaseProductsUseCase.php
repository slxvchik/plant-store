<?php

declare(strict_types=1);

namespace App\Application\Cart\UseCase;

interface PurchaseProductsUseCase
{
    /**
     * @param string[] $productIds
     */
    public function execute(array $productIds): void;
}
