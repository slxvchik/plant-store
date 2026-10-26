<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Warehouse\CreateWarehouse\CreateWarehouseUseCase;
use App\Application\Warehouse\DeleteWarehouse\DeleteWarehouseUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseUseCase;
use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseController extends Controller
{
    public function __construct(
        private readonly GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private readonly CreateWarehouseUseCase $createWarehouseUseCase,
        private readonly UpdateWarehouseUseCase $updateWarehouseUseCase,
        private readonly DeleteWarehouseUseCase $deleteWarehouseUseCase,
    ) {}

    public function index(): Response
    {
        return Inertia::render('admin/Warehouses', [
            'warehouses' => $this->getAllWarehousesUseCase->execute(),
        ]);
    }

    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        $this->createWarehouseUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Склад успешно добавлен.'));
    }

    public function update(UpdateWarehouseRequest $request, string $id): RedirectResponse
    {
        $this->updateWarehouseUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Склад успешно обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteWarehouseUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Склад успешно удалён.'));
    }
}
