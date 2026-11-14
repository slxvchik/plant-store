<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\ProductSupply\CreateProductSupply\CreateProductSupplyUseCase;
use App\Application\ProductSupply\DeleteProductSupply\DeleteProductSupplyUseCase;
use App\Application\ProductSupply\GetProductSupply\GetProductSupplyUseCase;
use App\Application\ProductSupply\GetProductSupplies\GetProductSuppliesUseCase;
use App\Application\ProductSupply\UpdateProductSupply\UpdateProductSupplyUseCase;
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
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $productSuppliesPage = $this->getProductSuppliesUseCase->execute($request->toPageable());

        return Inertia::render('admin/ProductSupplies', [
            'productSuppliesPage' => new PageResponseDto($productSuppliesPage, $request->fullUrl()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ProductSupplyCreate');
    }

    public function store(StoreProductSupplyRequest $request): RedirectResponse
    {
        $productSupplyId = $this->createProductSupplyUseCase->execute($request->toDto());

        return redirect()
            ->route('admin.product-supplies.show', $productSupplyId)
            ->with(Notification::flash('Поставка создана.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/ProductSupplyShow', [
            'productSupply' => $this->getProductSupplyUseCase->execute($id),
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

        return redirect()->back()->with(Notification::flash('Поставка удалена.'));
    }
}
