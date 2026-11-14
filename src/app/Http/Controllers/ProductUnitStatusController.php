<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\ProductUnitStatus\CreateProductUnitStatus\CreateProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\DeleteProductUnitStatus\DeleteProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\GetProductUnitStatus\GetProductUnitStatusUseCase;
use App\Application\ProductUnitStatus\GetProductUnitStatuses\GetProductUnitStatusesUseCase;
use App\Application\ProductUnitStatus\UpdateProductUnitStatus\UpdateProductUnitStatusUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ProductUnitStatus\StoreProductUnitStatusRequest;
use App\Http\Requests\ProductUnitStatus\UpdateProductUnitStatusRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class ProductUnitStatusController extends Controller
{
    public function __construct(
        private readonly GetProductUnitStatusesUseCase $getStatusesUseCase,
        private readonly GetProductUnitStatusUseCase $getStatusUseCase,
        private readonly CreateProductUnitStatusUseCase $createStatusUseCase,
        private readonly UpdateProductUnitStatusUseCase $updateStatusUseCase,
        private readonly DeleteProductUnitStatusUseCase $deleteStatusUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $statusesPage = $this->getStatusesUseCase->execute($request->toPageable());

        return Inertia::render('admin/ProductUnitStatuses', [
            'statusesPage' => new PageResponseDto($statusesPage, $request->fullUrl()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ProductUnitStatusCreate');
    }

    public function store(StoreProductUnitStatusRequest $request): RedirectResponse
    {
        $this->createStatusUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Статус единицы товара создан.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/ProductUnitStatusShow', [
            'status' => $this->getStatusUseCase->execute($id),
        ]);
    }

    public function update(UpdateProductUnitStatusRequest $request, string $id): RedirectResponse
    {
        $this->updateStatusUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Статус единицы товара обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteStatusUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Статус единицы товара удалён.'));
    }
}
