<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitUseCase;
use App\Application\ProductUnit\DeleteProductUnit\DeleteProductUnitUseCase;
use App\Application\ProductUnit\GetProductUnit\GetProductUnitUseCase;
use App\Application\ProductUnit\GetProductUnits\GetProductUnitsUseCase;
use App\Application\ProductUnit\UpdateProductUnit\UpdateProductUnitUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductUnit\StoreProductUnitRequest;
use App\Http\Requests\ProductUnit\UpdateProductUnitRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class ProductUnitController extends Controller
{
    public function __construct(
        private readonly GetProductUnitsUseCase $getProductUnitsUseCase,
        private readonly GetProductUnitUseCase $getProductUnitUseCase,
        private readonly CreateProductUnitUseCase $createProductUnitUseCase,
        private readonly UpdateProductUnitUseCase $updateProductUnitUseCase,
        private readonly DeleteProductUnitUseCase $deleteProductUnitUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $productUnitsPage = $this->getProductUnitsUseCase->execute($request->toPageable());

        return Inertia::render('admin/ProductUnits', [
            'productUnitsPage' => new PageResponseDto($productUnitsPage, $request->fullUrl()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ProductUnitCreate');
    }

    public function store(StoreProductUnitRequest $request): RedirectResponse
    {
        $this->createProductUnitUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Единица товара создана.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/ProductUnitShow', [
            'productUnit' => $this->getProductUnitUseCase->execute($id),
        ]);
    }

    public function update(UpdateProductUnitRequest $request, string $id): RedirectResponse
    {
        $this->updateProductUnitUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Единица товара обновлена.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteProductUnitUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Единица товара удалена.'));
    }
}
