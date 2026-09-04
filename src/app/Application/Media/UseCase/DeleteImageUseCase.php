<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

interface DeleteImageUseCase
{
    public function execute(string $id): void;
}
