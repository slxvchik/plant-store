<?php

declare(strict_types=1);

namespace App\Application\User\GetUserProfile;

interface GetUserProfileUseCase
{
    public function execute(string $userId): GetUserProfileResponseDto;
}
