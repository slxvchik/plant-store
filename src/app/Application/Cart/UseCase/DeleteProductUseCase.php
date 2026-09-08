<?php

namespace App\Application\Cart\UseCase;

interface DeleteProductUseCase
{
    public function execute(string $id): void;
}
