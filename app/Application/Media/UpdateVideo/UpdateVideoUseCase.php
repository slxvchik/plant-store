<?php

declare(strict_types=1);

namespace App\Application\Media\UpdateVideo;

interface UpdateVideoUseCase
{
    public function execute(UpdateVideoRequestDto $updateVideoRequestDto): void;
}
