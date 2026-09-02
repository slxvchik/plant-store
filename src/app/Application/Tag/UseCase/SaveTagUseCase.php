<?php

declare(strict_types=1);

namespace App\Application\Tag\UseCase;

use App\Application\Tag\Dto\Request\SaveTagRequestDto;

interface SaveTagUseCase
{
    public function execute(SaveTagRequestDto $saveTagRequestDto): string;
}
