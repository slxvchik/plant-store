<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

use App\Application\Media\Dto\Request\UpdateImageRequestDto;

interface UpdateImageUseCase
{
    public function execute(UpdateImageRequestDto $updateImageRequestDto): void;
}
