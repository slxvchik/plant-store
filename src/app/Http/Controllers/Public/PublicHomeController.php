<?php

namespace App\Http\Controllers\Public;

use App\Application\Product\GetFeaturedProducts\GetFeaturedProductsUseCase;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PublicHomeController extends Controller
{
    public function __construct(
        private readonly GetFeaturedProductsUseCase $getFeaturedProductsUseCase,
    ) {}

    public function index(): Response
    {
        return Inertia::render(
            'Home',
            [
                'featuredProducts' => $this->getFeaturedProductsUseCase->execute(),
            ],
        );
    }
}
