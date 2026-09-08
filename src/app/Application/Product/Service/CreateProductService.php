<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use App\Applicaiton\Category\Exception\CategoryNotFoundException;
use App\Application\Product\Dto\Request\CreateProductRequestDto;
use App\Application\Product\UseCase\CreateProductUseCase;
use App\Application\Tag\Exception\TagNotFoundException;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Media\Repository\VideoRepository;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\Tag\Repository\TagRepository;
use Override;

class CreateProductService implements CreateProductUseCase
{
    public function __construct(
        private final UuidGeneratorInterface $uuidGeneratorInterface,
        private final ProductRepository $productRepository,
        private final CategoryRepository $categoryRepository,
        private final TagRepository $tagRepository,
        private final ImageRepository $imageRepository,
        private final VideoRepository $videoRepository
    ) {}

    #[Override]
    public function execute(CreateProductRequestDto $createProductRequestDto): string
    {
        foreach ($createProductRequestDto->categoryIds as $categoryId) {
            $category = $this->categoryRepository->findById($categoryId);
            if ($category === null) {
                throw new CategoryNotFoundException($categoryId);
            }
        }

        foreach ($createProductRequestDto->tagIds as $tagId) {
            $tag = $this->tagRepository->findById($tagId);
            if ($tag === null) {
                throw new TagNotFoundException($tagId);
            }
        }

        // TODO: check images & video

        $product = Product::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            active: $createProductRequestDto->active,
            alias: $createProductRequestDto->alias,
            name: $createProductRequestDto->name,
            categories: $createProductRequestDto->categoryIds,
            tags: $createProductRequestDto->tagIds,
            videoIds: $createProductRequestDto->videoIds,
            imageIds: $createProductRequestDto->imageIds,
            description: $createProductRequestDto->description
        );

        $existingProduct = $this->productRepository->findByAlias($product->alias);
        if ($existingProduct !== null && $existingProduct->id->value !== $product->id->value) {
            // TODO: product alias exception
        }

        return $this->productRepository->create($product);
    }
}
