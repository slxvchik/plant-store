<?php

declare(strict_types=1);

namespace App\Application\Category\UseCase;

use App\Application\Category\Dto\Response\CategoryResponseDto;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;

interface GetCategoryPageUserCase
{
    /**
     * @return Page<CategoryResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
