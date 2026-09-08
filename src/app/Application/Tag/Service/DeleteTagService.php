<?php

declare(strict_types=1);

namespace App\Application\Tag\Service;

use App\Application\Tag\Exception\TagNotFoundException;
use App\Application\Tag\UseCase\DeleteTagUseCase;
use App\Domain\Tag\Repository\TagRepository;
use Override;

class DeleteTagService implements DeleteTagUseCase
{
    public function __construct(
        private final TagRepository $tagRepository
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $tag = $this->tagRepository->findById($id);
        if ($tag === null) {
            throw new TagNotFoundException();
        }

        $this->tagRepository->delete($id);
    }
}
