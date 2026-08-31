<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Dto\Request\SaveProductRequestDto;

interface SaveProductUseCase
{
    public function execute(SaveProductRequestDto $saveProductRequestDto): string;
}
