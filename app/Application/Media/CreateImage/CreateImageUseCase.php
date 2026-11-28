<?php

declare(strict_types=1);

namespace App\Application\Media\CreateImage;

interface CreateImageUseCase
{
    public function execute(CreateImageRequestDto $createImageRequestDto): string;
}
