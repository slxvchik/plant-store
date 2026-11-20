<?php

namespace App\Http\Controllers\Public;

use App\Application\Product\GetFeaturedProducts\GetFeaturedProductsUseCase;
use App\Application\Product\SearchProducts\SearchProductsUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function __construct(
        private readonly GetFeaturedProductsUseCase $getFeaturedProductsUseCase,
        private readonly SearchProductsUseCase $searchProductsUseCase,
    ) {}

    public function search(): JsonResponse

    public function featured(): JsonResponse
    {
        return response()->json([
            'products' => $this->getFeaturedProductsUseCase->execute()
        ]);
    }
}
