<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

use App\Application\Media\Dto\Request\UpdateVideoRequestDto;

interface UpdateVideoUseCase
{
    public function execute(UpdateVideoRequestDto $updateVideoRequestDto): void;
}
