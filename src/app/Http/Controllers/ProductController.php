<?php

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Media\DeleteImage\DeleteImageUseCase;
use App\Application\Product\CreateProduct\CreateProductUseCase;
use App\Application\Product\UpdateProduct\UpdateProductUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Domain\Shared\Pagination\Page;
use App\Http\Requests\StoreProductRequest;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Inertia\Inertia;
use InvalidArgumentException;
use ValueError;

class ProductController extends Controller
{
    public function __construct(
        private readonly GetAllCategoriesUseCase $getAllCategoriesUseCase,
        private readonly GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private readonly CreateProductUseCase $createProductUseCase,
        private readonly UpdateProductUseCase $updateProductUseCase,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/products/ProductsIndex', [
            'productsPage' => new PageResponseDto(
                page: Page::empty(),
                url: route('admin.products.index'),
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws InvalidArgumentException
     */
    public function create()
    {
        $categories = $this->getAllCategoriesUseCase->execute();
        $warehouses = $this->getAllWarehousesUseCase->execute();

        return Inertia::render('admin/products/CreateProduct', [
            'categories' => $categories,
            'warehouses' => $warehouses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws ValueError
     */
    public function store(StoreProductRequest $request)
    {
        $productId = $this->createProductUseCase->execute($request->getCreateProductData());

        return redirect()->back('admin.products.edit', $productId)->with([
            new Notification(
                'Продукт создан',
                NotificationType::SUCCESS,
            ),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/products/ShowProduct');
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws ValueError
     */
    public function update(StoreProductRequest $request, string $id)
    {
        $request->validated();

        $this->updateProductUseCase->execute($request->getUpdateProductData());

        return redirect()->back()->with([
            new Notification(
                'Продукт создан.',
                NotificationType::SUCCESS,
            ),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
