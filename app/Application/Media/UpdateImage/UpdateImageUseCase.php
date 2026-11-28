<?php

declare(strict_types=1);

namespace App\Application\Media\UpdateImage;

interface UpdateImageUseCase
{
    public function execute(UpdateImageRequestDto $updateImageRequestDto): void;
}
