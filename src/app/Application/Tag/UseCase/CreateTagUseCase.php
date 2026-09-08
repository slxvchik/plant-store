<?php

declare(strict_types=1);

namespace App\Application\Tag\UseCase;

use App\Application\Tag\Dto\Request\CreateTagRequestDto;

interface CreateTagUseCase
{
    public function execute(CreateTagRequestDto $createTagRequestDto): string;
}
