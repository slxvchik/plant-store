<?php

namespace App\Http\Controllers\Public;

use App\Application\Product\SearchProducts\SearchProductsUseCase;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\PaginationRequest;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class PublicCatalogController extends Controller
{
    public function __construct(
        private readonly SearchProductsUseCase $searchProductsUseCase,
    ) {}

    public function index(PaginationRequest $paginationRequest): Response
    {
        return Inertia::render(
            'catalog/CatalogIndex',
            [
                'productsPage' => $this->searchProductsUseCase->execute(
                    criteria: new ProductSearchCriteria(
                        active: true,
                    ),
                    pageable: $paginationRequest->toPageable(),
                ),
            ]
        );
    }
}
