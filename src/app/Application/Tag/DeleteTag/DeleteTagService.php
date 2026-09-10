<?php

declare(strict_types=1);

namespace App\Application\Tag\DeleteTag;

use App\Application\Tag\Shared\Exception\TagNotFoundException;
use App\Domain\Tag\Repository\TagRepository;
use Override;

readonly class DeleteTagService implements DeleteTagUseCase
{
    public function __construct(
        private TagRepository $tagRepository
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
