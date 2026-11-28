<?php

declare(strict_types=1);

namespace App\Application\Media\DeleteVideo;

interface DeleteVideoUseCase
{
    public function execute(string $id): void;
}
