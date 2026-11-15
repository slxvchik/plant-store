<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Supplier\CreateSupplier\CreateSupplierUseCase;
use App\Application\Supplier\DeleteSupplier\DeleteSupplierUseCase;
use App\Application\Supplier\GetSupplier\GetSupplierUseCase;
use App\Application\Supplier\GetSuppliers\GetSuppliersUseCase;
use App\Application\Supplier\UpdateSupplier\UpdateSupplierUseCase;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\SupplierIndexRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class SupplierController extends Controller
{
    public function __construct(
        private readonly GetSuppliersUseCase $getSuppliersUseCase,
        private readonly GetSupplierUseCase $getSupplierUseCase,
        private readonly CreateSupplierUseCase $createSupplierUseCase,
        private readonly UpdateSupplierUseCase $updateSupplierUseCase,
        private readonly DeleteSupplierUseCase $deleteSupplierUseCase,
    ) {}

    public function index(SupplierIndexRequest $request): Response
    {
        $suppliersPage = $this->getSuppliersUseCase->execute($request->toPageable(), $request->search());

        return Inertia::render('admin/suppliers/Suppliers', [
            'suppliersPage' => new PageResponseDto($suppliersPage, $request->fullUrl()),
            'filters' => ['search' => $request->search() ?? ''],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/suppliers/SupplierCreate');
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $this->createSupplierUseCase->execute($request->toDto());

        return redirect()->route('admin.suppliers.index')->with(Notification::flash('Поставщик создан.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/suppliers/SupplierShow', [
            'supplier' => $this->getSupplierUseCase->execute($id),
        ]);
    }

    public function update(UpdateSupplierRequest $request, string $id): RedirectResponse
    {
        $this->updateSupplierUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Поставщик обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteSupplierUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Поставщик удалён.'));
    }
}
