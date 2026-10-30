<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Product\CreateProduct\CreateProductUseCase;
use App\Application\Product\DeleteProduct\DeleteProductUseCase;
use App\Application\Product\GetDetailProduct\GetDetailProductRequestDto;
use App\Application\Product\GetDetailProduct\GetDetailProductUseCase;
use App\Application\Product\GetProducts\GetProductsUseCase;
use App\Application\Product\UpdateProduct\UpdateProductUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly GetAllCategoriesUseCase $getAllCategoriesUseCase,
        private readonly GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private readonly GetProductsUseCase $getProductsUseCase,
        private readonly GetDetailProductUseCase $getDetailProductUseCase,
        private readonly CreateProductUseCase $createProductUseCase,
        private readonly UpdateProductUseCase $updateProductUseCase,
        private readonly DeleteProductUseCase $deleteProductUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $productPage = $this->getProductsUseCase->execute($request->toPageable());

        return Inertia::render('admin/products/ProductsIndex', [
            'productsPage' => new PageResponseDto($productPage, $request->fullUrl()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/products/CreateProduct', [
            'categories' => $this->getAllCategoriesUseCase->execute(),
            'warehouses' => $this->getAllWarehousesUseCase->execute(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $productId = $this->createProductUseCase->execute($request->toDto());

        return redirect()
            ->route('admin.products.show', $productId)
            ->with(Notification::flash('Продукт создан.'));
    }

    public function show(string $id): Response
    {
        $product = $this->getDetailProductUseCase->execute(new GetDetailProductRequestDto($id, null));

        return Inertia::render('admin/products/ShowProduct', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $this->updateProductUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Продукт обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteProductUseCase->execute($id);

        return redirect()->back()->with([
            Notification::flash('Продукт удалён'),
        ]);
    }
}
