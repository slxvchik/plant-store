<?php

namespace App\Application\Order\UseCase;

interface CompleteOrderUseCase
{
    public function execute(string $id): void;
}
