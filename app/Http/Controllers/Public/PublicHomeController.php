<?php

namespace App\Http\Controllers\Public;

use App\Application\MainPageGallery\GetActiveSlides\GetActiveSlidesUseCase;
use App\Application\Product\GetFeaturedProducts\GetFeaturedProductsUseCase;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PublicHomeController extends Controller
{
    public function __construct(
        private readonly GetActiveSlidesUseCase $getActiveSlidesUseCase,
        private readonly GetFeaturedProductsUseCase $getFeaturedProductsUseCase,
    ) {}

    public function index(): Response
    {
        return Inertia::render(
            'Home',
            [
                'gallery' => $this->getActiveSlidesUseCase->execute(),
                'featuredProducts' => $this->getFeaturedProductsUseCase->execute(),
            ],
        );
    }
}
