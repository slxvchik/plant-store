<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart;

use App\Application\Cart\GetUserCart\Dto\Request\GetUserCartRequestDto;
use App\Application\Cart\GetUserCart\Dto\Response\GetUserCartResponseDto;
use App\Application\Cart\Shared\Exception\CartNotFoundException;

interface GetUserCartUseCase
{
    /**
     * @throws CartNotFoundException
     * @param GetUserCartRequestDto $getUserCartRequestDto
     * @return GetUserCartResponseDto
     */
    public function execute(GetUserCartRequestDto $getUserCartRequestDto): GetUserCartResponseDto;
}
