<?php

declare(strict_types=1);

namespace App\Application\Category\GetCategoriesPage;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetCategoriesPageUseCase
{
    /**
     * @return Page<CategoryResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
