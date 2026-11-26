<?php

namespace App\Adapters;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Application\Media\GetImagesByIds\GetImagesByIdsUseCase;
use App\Application\Product\Shared\Dto\Response\OfferResponseDto;
use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Domain\Category\CategoryRepository;
use App\Domain\Product\Model\OfferModel;
use App\Domain\Product\Model\ProductModel;
use App\Domain\Tag\TagRepository;

readonly class ProductDetailsFetcherImpl implements ProductDetailsFetcher
{
    public function __construct(
        private TagRepository $tagRepository,
        private CategoryRepository $categoryRepository,
        private GetImagesByIdsUseCase $getImagesByIdsUseCase,
        //        private readonly VideoRepository $videoRepository,
    ) {}

    /**
     * @param  ProductModel[]  $products
     * @return ProductResponseDto[]
     */
    public function execute(array $products): array
    {
        $tagMap = $this->buildTagMap($products);
        $categoryMap = $this->buildCategoryMap($products);
        $imageMap = $this->buildImageMap($products);

        return array_map(function (ProductModel $product) use ($categoryMap, $tagMap, $imageMap) {
            $sortedImageObjects = $product->imageIds;

            usort($sortedImageObjects, fn ($a, $b) => $a->sort <=> $b->sort);

            $sortedImageIds = array_column($sortedImageObjects, 'id');

            $offers = $product->getOffers();

            return ProductResponseDto::fromDomain(
                product: $product,
                offers: array_map(
                    function (OfferModel $offer) use ($imageMap): OfferResponseDto {
                        $currentOfferImageIds = array_column($offer->imageIds, 'id');

                        $images = array_values(array_filter(
                            array_map(fn ($id) => $imageMap[$id] ?? null, $currentOfferImageIds)
                        ));

                        return OfferResponseDto::fromDomain(
                            offer: $offer,
                            images: $images,
                        );
                    },
                    $offers
                ),
                category: $categoryMap[$product->categoryId] ?? null,
                tags: array_filter(array_map(fn ($id) => $tagMap[$id] ?? null, $product->tagIds)),
                images: array_filter(array_map(fn ($id) => $imageMap[$id] ?? null, $sortedImageIds)),
                videos: [],
            );
        }, $products);
    }

    private function buildTagMap(array $products): array
    {
        $ids = array_unique(array_merge(...array_column($products, 'tagIds')));
        $tags = $this->tagRepository->findByIds($ids);

        return array_column(
            array_map(fn ($tag) => TagResponseDto::fromDomain($tag), $tags),
            null,
            'id'
        );
    }

    private function buildCategoryMap(array $products): array
    {
        $ids = [];
        foreach ($products as $product) {
            if ($product->categoryId !== null) {
                $ids[] = $product->categoryId;
            }
        }
        $categories = $this->categoryRepository->findByIds($ids);

        $map = [];
        foreach ($categories as $category) {
            $map[$category->id->value] = CategoryResponseDto::fromDomain($category, null);
        }

        return $map;
    }

    /**
     * @param  ProductModel[]  $products
     */
    private function buildImageMap(array $products): array
    {
        $imageIdGroups = [];

        foreach ($products as $product) {
            if (! empty($product->imageIds)) {
                $imageIdGroups[] = array_column($product->imageIds, 'id');
            }

            foreach ($product->getOffers() as $offer) {
                if (! empty($offer->imageIds)) {
                    $imageIdGroups[] = array_column($offer->imageIds, 'id');
                }
            }
        }

        $ids = array_values(array_unique(array_merge(...$imageIdGroups)));

        $images = $this->getImagesByIdsUseCase->execute($ids);

        $map = [];
        foreach ($images as $image) {
            $map[$image->id] = $image;
        }

        return $map;
    }
}
