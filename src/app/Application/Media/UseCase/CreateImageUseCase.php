<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

use App\Application\Media\Dto\Request\CreateImageRequestDto;

interface CreateImageUseCase
{
    public function execute(CreateImageRequestDto $createImageRequestDto): string;
}
