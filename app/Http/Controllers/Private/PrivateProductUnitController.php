<?php

declare(strict_types=1);

namespace App\Http\Controllers\Private;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Product\GetProductOptions\GetProductOptionsUseCase;
use App\Application\ProductSupply\GetAllProductSupplies\GetAllProductSuppliesUseCase;
use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsUseCase;
use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitUseCase;
use App\Application\ProductUnit\DeleteProductUnit\DeleteProductUnitUseCase;
use App\Application\ProductUnit\GetProductUnit\GetProductUnitUseCase;
use App\Application\ProductUnit\GetProductUnits\GetProductUnitsUseCase;
use App\Application\ProductUnit\UpdateProductUnit\UpdateProductUnitUseCase;
use App\Application\ProductUnitStatus\GetAllProductUnitStatuses\GetAllProductUnitStatusesUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Private\ProductUnit\BatchCreateProductUnitsRequest;
use App\Http\Requests\Private\ProductUnit\ProductUnitIndexRequest;
use App\Http\Requests\Private\ProductUnit\StoreProductUnitRequest;
use App\Http\Requests\Private\ProductUnit\UpdateProductUnitRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class PrivateProductUnitController extends Controller
{
    public function __construct(
        private readonly GetProductUnitsUseCase $getProductUnitsUseCase,
        private readonly GetProductUnitUseCase $getProductUnitUseCase,
        private readonly CreateProductUnitUseCase $createProductUnitUseCase,
        private readonly BatchCreateProductUnitsUseCase $batchCreateProductUnitsUseCase,
        private readonly UpdateProductUnitUseCase $updateProductUnitUseCase,
        private readonly DeleteProductUnitUseCase $deleteProductUnitUseCase,
        private readonly GetProductOptionsUseCase $getProductOptionsUseCase,
        private readonly GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private readonly GetAllProductUnitStatusesUseCase $getAllStatusesUseCase,
        private readonly GetAllProductSuppliesUseCase $getAllSuppliesUseCase,
    ) {}

    public function index(ProductUnitIndexRequest $request): Response
    {
        $productUnitsPage = $this->getProductUnitsUseCase->execute($request->toPageable(), $request->toCriteria());

        return Inertia::render('admin/product-unit/ProductUnits', [
            'productUnitsPage' => new PageResponseDto($productUnitsPage, $request->fullUrl()),
            'filters' => $request->filters(),
            ...$this->formOptions(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/product-unit/ProductUnitCreate', $this->formOptions());
    }

    public function store(StoreProductUnitRequest $request): RedirectResponse
    {
        $this->createProductUnitUseCase->execute($request->toDto());

        return redirect()->route('admin.product-units.index')->with(Notification::flash('Единица товара создана.'));
    }

    public function storeBatch(BatchCreateProductUnitsRequest $request): RedirectResponse
    {
        $ids = $this->batchCreateProductUnitsUseCase->execute($request->toDto());

        return redirect()->route('admin.product-units.index')->with(Notification::flash('Создано единиц товара: '.count($ids).'.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/product-unit/ProductUnitShow', [
            'productUnit' => $this->getProductUnitUseCase->execute($id),
            ...$this->formOptions(),
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

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'products' => $this->getProductOptionsUseCase->execute(),
            'warehouses' => $this->getAllWarehousesUseCase->execute(),
            'statuses' => $this->getAllStatusesUseCase->execute(),
            'supplies' => $this->getAllSuppliesUseCase->execute(),
        ];
    }
}
