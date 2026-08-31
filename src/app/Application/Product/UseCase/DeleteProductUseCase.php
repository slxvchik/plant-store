<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

interface DeleteProductUseCase
{
    public function execute(string $id): void;
}
