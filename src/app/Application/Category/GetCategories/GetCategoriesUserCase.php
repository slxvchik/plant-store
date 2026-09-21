<?php

declare(strict_types=1);

namespace App\Application\Category\GetCategories;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetCategoriesUserCase
{
    /**
     * @return Page<CategoryResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
