<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\Dto\Response\GetProfileResponseDto;

interface GetProfileUseCase
{
    public function execute(string $userId): GetProfileResponseDto;
}
