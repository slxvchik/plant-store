<?php

declare(strict_types=1);

namespace App\Application\Tag\UseCase;

use App\Application\Tag\Dto\Request\UpdateTagRequestDto;

interface UpdateTagUseCase
{
    public function execute(UpdateTagRequestDto $updateTagRequestDto): void;
}
