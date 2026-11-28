<?php

declare(strict_types=1);

namespace App\Application\Media\CreateVideo;

interface CreateVideoUseCase
{
    public function execute(CreateVideoRequestDto $createVideoRequestDto): string;
}
