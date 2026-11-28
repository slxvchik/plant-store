<?php

declare(strict_types=1);

namespace App\Application\Category\GetAllCategories;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetAllCategoriesUseCase
{
    /**
     * @return CategoryResponseDto[]
     */
    public function execute(): array;
}
