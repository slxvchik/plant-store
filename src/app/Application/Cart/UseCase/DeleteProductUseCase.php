<?php

namespace App\Application\Cart\UseCase;

interface DeleteProductUseCase
{
    public function execute(string $productId, string $offerId): void;
}
