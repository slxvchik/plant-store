<?php

declare(strict_types=1);

namespace App\Application\User\GetUserProfile;

use Override;

readonly class GetUserProfileService implements GetUserProfileUseCase
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function execute(string $userId): GetUserProfileResponseDto
    {
        throw new \Exception('Not implemented');
    }
}
