<?php

namespace App\Http\Controllers;

use App\Application\Warehouse\CreateWarehouse\CreateWarehouseUseCase;
use App\Application\Warehouse\DeleteWarehouse\DeleteWarehouseUseCase;
use App\Application\Warehouse\GetAllWarehouses\GetAllWarehousesUseCase;
use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseUseCase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WarehouseController extends Controller
{
    public function __construct(
        private GetAllWarehousesUseCase $getAllWarehousesUseCase,
        private CreateWarehouseUseCase $createWarehouseUseCase,
        private UpdateWarehouseUseCase $updateWarehouseUseCase,
        private DeleteWarehouseUseCase $deleteWarehouseUseCase
    ) {}

    public function index()
    {
        $warehouses = $this->getAllWarehousesUseCase->execute();
        return Inertia::render('admin/Warehouses', ['warehouses' => $warehouses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
