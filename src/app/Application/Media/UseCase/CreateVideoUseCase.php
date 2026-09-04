<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

use App\Application\Media\Dto\Request\CreateVideoRequestDto;

interface CreateVideoUseCase
{
    public function execute(CreateVideoRequestDto $createVideoRequestDto): string;
}
