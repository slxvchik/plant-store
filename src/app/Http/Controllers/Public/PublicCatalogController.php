<?php

namespace App\Http\Controllers\Public;

use App\Application\Category\GetAllCategories\GetAllCategoriesService;
use App\Application\Product\GetDetailProduct\GetDetailProductRequestDto;
use App\Application\Product\GetDetailProduct\GetDetailProductUseCase;
use App\Application\Product\GetOfferMaxPrice\GetOfferMaxPriceUseCase;
use App\Application\Product\GetOfferMinPrice\GetOfferMinPriceUseCase;
use App\Application\Product\SearchProducts\SearchProductsUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\CatalogSearchRequest;
use Inertia\Inertia;
use Inertia\Response;

class PublicCatalogController extends Controller
{
    public function __construct(
        private readonly GetOfferMinPriceUseCase $getOfferMinPriceUseCase,
        private readonly GetOfferMaxPriceUseCase $getOfferMaxPriceUseCase,
        private readonly GetAllCategoriesService $getAllCategoriesService,
        private readonly SearchProductsUseCase   $searchProductsUseCase,
        private readonly GetDetailProductUseCase $getDetailProductUseCase,
    ) {}

    public function index(CatalogSearchRequest $catalogSearchRequest): Response
    {
        return Inertia::render(
            'catalog/CatalogIndex',
            [
                'categories' => array_filter($this->getAllCategoriesService->execute(), fn($category) => $category->active),
                'minPrice' => $this->getOfferMinPriceUseCase->execute() ?? 0,
                'maxPrice' => $this->getOfferMaxPriceUseCase->execute() ?? 0,
                'productsPage' => $this->searchProductsUseCase->execute(
                    criteria: $catalogSearchRequest->toCriteria(),
                    pageable: $catalogSearchRequest->toPageable(),
                ),
            ],
        );
    }

    public function showProduct(string $alias): Response
    {
        return Inertia::render(
            'catalog/ProductDetail',
            [
                'product' => $this->getDetailProductUseCase->execute(
                    new GetDetailProductRequestDto(
                        id: null,
                        alias: $alias,
                    ),
                ),
            ]
        );
    }
}
