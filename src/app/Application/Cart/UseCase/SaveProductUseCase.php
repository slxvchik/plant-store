<?php

namespace App\Application\Cart\UseCase;

interface SaveProductUseCase
{
    public function execute(string $productId, string $offerId, int $quantity): void;
}
