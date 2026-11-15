<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Product\GetProductOptions\GetProductOptionsUseCase;
use App\Application\ProductSupply\CreateProductSupply\CreateProductSupplyUseCase;
use App\Application\ProductSupply\DeleteProductSupply\DeleteProductSupplyUseCase;
use App\Application\ProductSupply\GetProductSupply\GetProductSupplyUseCase;
use App\Application\ProductSupply\GetProductSupplies\GetProductSuppliesUseCase;
use App\Application\ProductSupply\UpdateProductSupply\UpdateProductSupplyUseCase;
use App\Application\ProductUnit\GetProductSupplyUnits\GetProductSupplyUnitsUseCase;
use App\Application\ProductUnitStatus\GetAllProductUnitStatuses\GetAllProductUnitStatusesUseCase;
use App\Application\Supplier\GetAllSuppliers\GetAllSuppliersUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductSupply\StoreProductSupplyRequest;
use App\Http\Requests\ProductSupply\UpdateProductSupplyRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class ProductSupplyController extends Controller
{
    public function __construct(
        private readonly GetProductSuppliesUseCase $getProductSuppliesUseCase,
        private readonly GetProductSupplyUseCase $getProductSupplyUseCase,
        private readonly CreateProductSupplyUseCase $createProductSupplyUseCase,
        private readonly UpdateProductSupplyUseCase $updateProductSupplyUseCase,
        private readonly DeleteProductSupplyUseCase $deleteProductSupplyUseCase,
        private readonly GetProductSupplyUnitsUseCase $getProductSupplyUnitsUseCase,
        private readonly GetProductOptionsUseCase $getProductOptionsUseCase,
        private readonly GetAllSuppliersUseCase $getAllSuppliersUseCase,
        private readonly GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private readonly GetAllProductUnitStatusesUseCase $getAllStatusesUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $productSuppliesPage = $this->getProductSuppliesUseCase->execute($request->toPageable());

        return Inertia::render('admin/product-supply/ProductSupplies', [
            'productSuppliesPage' => new PageResponseDto($productSuppliesPage, $request->fullUrl()),
            'products' => $this->getProductOptionsUseCase->execute(),
            'suppliers' => $this->getAllSuppliersUseCase->execute(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/product-supply/ProductSupplyCreate', $this->formOptions());
    }

    public function store(StoreProductSupplyRequest $request): RedirectResponse
    {
        $productSupplyId = $this->createProductSupplyUseCase->execute($request->toDto());

        return redirect()->route('admin.product-supplies.show', $productSupplyId)
            ->with(Notification::flash('Поставка создана.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/product-supply/ProductSupplyShow', [
            'productSupply' => $this->getProductSupplyUseCase->execute($id),
            'productUnits' => $this->getProductSupplyUnitsUseCase->execute($id),
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateProductSupplyRequest $request, string $id): RedirectResponse
    {
        $this->updateProductSupplyUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Поставка обновлена.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteProductSupplyUseCase->execute($id);

        return redirect()->route('admin.product-supplies.index')->with(Notification::flash('Поставка удалена.'));
    }

    /**
     * @return array<string, mixed>
     */
    private function formOptions(): array
    {
        return [
            'products' => $this->getProductOptionsUseCase->execute(),
            'suppliers' => $this->getAllSuppliersUseCase->execute(),
            'warehouses' => $this->getAllWarehousesUseCase->execute(),
            'statuses' => $this->getAllStatusesUseCase->execute(),
        ];
    }
}
