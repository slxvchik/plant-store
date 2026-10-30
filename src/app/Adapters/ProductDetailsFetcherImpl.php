<?php

namespace App\Adapters;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Application\Media\Shared\FileStorageInterface;
use App\Application\Product\Shared\Dto\Response\OfferResponseDto;
use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Application\Product\Shared\Dto\Response\StockResponseDto;
use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Application\Warehouse\Shared\Dto\Response\WarehouseResponseDto;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Product\Model\Offer;
use App\Domain\Product\Model\Product;
use App\Domain\Tag\Repository\TagRepository;
use App\Domain\Warehouse\Repository\WarehouseRepository;

readonly class ProductDetailsFetcherImpl implements ProductDetailsFetcher
{
    public function __construct(
        private FileStorageInterface $fileStorage,
        private TagRepository $tagRepository,
        private CategoryRepository $categoryRepository,
        private ImageRepository $imageRepository,
        private WarehouseRepository $warehouseRepository,
        //        private readonly VideoRepository $videoRepository,
    ) {}

    /**
     * @param  Product[]  $products
     * @return ProductResponseDto[]
     */
    public function execute(array $products): array
    {
        $tagMap = $this->buildTagMap($products);
        $categoryMap = $this->buildCategoryMap($products);
        $imageMap = $this->buildImageMap($products);
        $warehouseMap = $this->buildWarehouseMap($products);

        return array_map(function (Product $product) use ($warehouseMap, $categoryMap, $tagMap, $imageMap) {
            $sortedImageObjects = $product->imageIds;

            usort($sortedImageObjects, fn ($a, $b) => $a->sort <=> $b->sort);

            $sortedImageIds = array_column($sortedImageObjects, 'id');

            return ProductResponseDto::fromDomain(
                product: $product,
                offers: array_map(
                    fn (Offer $offer) => $this->buildOfferDto($offer, $warehouseMap),
                    $product->getOffers()
                ),
                categories: array_filter(array_map(fn ($id) => $categoryMap[$id] ?? null, $product->categoryIds)),
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
        $ids = array_unique(array_merge(...array_column($products, 'categoryIds')));
        $categories = $this->categoryRepository->findByIds($ids);

        $map = [];
        foreach ($categories as $category) {
            $map[$category->id->value] = CategoryResponseDto::fromDomain($category, null);
        }

        return $map;
    }

    private function buildImageMap(array $products): array
    {
        $ids = array_unique(
            array_merge(
                ...array_map(fn ($images) => array_column($images, 'id'), array_column($products, 'imageIds'))
            )
        );
        $images = $this->imageRepository->findByIds($ids);

        $map = [];
        foreach ($images as $image) {
            $webPath = $this->fileStorage->url($image->id->value);
            $map[$image->id->value] = ImageResponseDto::fromDomain($image, $webPath);
        }

        return $map;
    }

    private function buildWarehouseMap(array $products): array
    {
        $warehouseIds = [];
        foreach ($products as $product) {
            foreach ($product->getOffers() as $offer) {
                foreach ($offer->stocks as $stock) {
                    $warehouseIds[] = $stock->warehouseId;
                }
            }
        }

        $warehouses = $this->warehouseRepository->findByIds(array_unique($warehouseIds));
        $map = [];
        foreach ($warehouses as $warehouse) {
            $map[$warehouse->id->value] = WarehouseResponseDto::fromDomain($warehouse);
        }

        return $map;
    }

    private function buildOfferDto(Offer $offer, array $warehouseMap): OfferResponseDto
    {
        $stockDtos = [];
        foreach ($offer->stocks as $stock) {
            $warehouseId = $stock->warehouseId;
            if (isset($warehouseMap[$warehouseId])) {
                $stockDtos[] = StockResponseDto::fromDomain($stock, $warehouseMap[$warehouseId]);
            }
        }

        return OfferResponseDto::fromDomain($offer, $stockDtos);
    }
}
