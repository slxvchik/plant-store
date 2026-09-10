<?php

declare(strict_types=1);

namespace App\Application\Category\GetCategoryPage;

use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

class GetCategoryPageService implements GetCategoryPageUserCase
{
    public function __construct(
        private final CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        return $this->categoryRepository->findPage($pageable);
    }
}
