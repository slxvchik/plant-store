<?php

declare(strict_types=1);

namespace App\Application\Tag\Service;

use App\Application\Tag\Dto\Request\UpdateTagRequestDto;
use App\Application\Tag\Exception\TagAliasExistsException;
use App\Application\Tag\Exception\TagNotFoundException;
use App\Application\Tag\UseCase\UpdateTagUseCase;
use App\Domain\Tag\Repository\TagRepository;
use Override;

class UpdateTagService implements UpdateTagUseCase
{
    public function __construct(
        private final TagRepository $tagRepository
    ) {}

    #[Override]
    public function execute(UpdateTagRequestDto $updateTagRequestDto): void
    {
        $tag = $this->tagRepository->findById($updateTagRequestDto->id);
        if ($tag === null) {
            throw new TagNotFoundException();
        }

        $tag->update(
            alias: $updateTagRequestDto->alias,
            name: $updateTagRequestDto->name,
            active: $updateTagRequestDto->active
        );

        $existingTag = $this->tagRepository->findByAlias($tag->alias);

        if ($existingTag !== null && $existingTag->id->value !== $tag->id->value) {
            throw new TagAliasExistsException($tag->alias);
        }

        $this->tagRepository->update($tag);
    }
}
