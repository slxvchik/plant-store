<?php

declare(strict_types=1);

namespace App\Application\Tag\UseCase;

use App\Application\Tag\Dto\Response\TagResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetTagPageUseCase
{
    /**
     * @return Page<TagResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
