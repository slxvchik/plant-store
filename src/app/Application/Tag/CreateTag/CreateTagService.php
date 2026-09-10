<?php

declare(strict_types=1);

namespace App\Application\Tag\CreateTag;

use App\Application\Tag\Shared\Exception\TagAliasExistsException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Tag\Model\Tag;
use App\Domain\Tag\Repository\TagRepository;
use Override;

readonly class CreateTagService implements CreateTagUseCase
{
    public function __construct(
        private TagRepository $tagRepository,
        private UuidGeneratorInterface $uuidGeneratorInterface
    ) {}

    #[Override]
    public function execute(CreateTagRequestDto $createTagRequestDto): string
    {
        $tagExists = $this->tagRepository->findByAlias($createTagRequestDto->alias) !== null;

        if ($tagExists) {
            throw new TagAliasExistsException($createTagRequestDto->alias);
        }

        $tag = Tag::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            alias: $createTagRequestDto->alias,
            name: $createTagRequestDto->name,
            active: $createTagRequestDto->active
        );

        return $this->tagRepository->create($tag);
    }
}
