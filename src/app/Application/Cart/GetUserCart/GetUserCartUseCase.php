<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart;

use App\Application\Cart\GetUserCart\Dto\Request\GetUserCartRequestDto;
use App\Application\Cart\GetUserCart\Dto\Response\GetUserCartResponseDto;

interface GetUserCartUseCase
{
    public function execute(GetUserCartRequestDto $getUserCartRequestDto): GetUserCartResponseDto;
}
