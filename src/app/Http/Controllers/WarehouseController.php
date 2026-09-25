<?php

namespace App\Http\Controllers;

use App\Application\Warehouse\CreateWarehouse\CreateWarehouseRequestDto;
use App\Application\Warehouse\CreateWarehouse\CreateWarehouseUseCase;
use App\Application\Warehouse\DeleteWarehouse\DeleteWarehouseUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseUseCase;
use App\Enums\NotificationType;
use App\Http\Resources\Admin\WarehouseAdminResource;
use App\ValueObjects\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WarehouseController extends Controller
{
    public function __construct(
        private GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private CreateWarehouseUseCase $createWarehouseUseCase,
        private UpdateWarehouseUseCase $updateWarehouseUseCase,
        private DeleteWarehouseUseCase $deleteWarehouseUseCase
    ) {}

    public function index(): Response
    {
        $warehouses = $this->getAllWarehousesUseCase->execute();
        $warehouseAdminResources = WarehouseAdminResource::collection($warehouses);
        return Inertia::render('admin/Warehouses', ['warehouses' => $warehouseAdminResources]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $createDto = new CreateWarehouseRequestDto(
            address: $request->input('address'),
            phoneNumber: $request->input('phone')
        );
        $this->createWarehouseUseCase->execute($createDto);

        return redirect()->back()->with(
            new Notification(
                'Склад успешно добавлен!',
                NotificationType::SUCCESS
            )->toArray()
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
