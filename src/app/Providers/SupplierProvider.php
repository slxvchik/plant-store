<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Supplier\CreateSupplier\CreateSupplierService;
use App\Application\Supplier\CreateSupplier\CreateSupplierUseCase;
use App\Application\Supplier\DeleteSupplier\DeleteSupplierService;
use App\Application\Supplier\DeleteSupplier\DeleteSupplierUseCase;
use App\Application\Supplier\GetSupplier\GetSupplierService;
use App\Application\Supplier\GetSupplier\GetSupplierUseCase;
use App\Application\Supplier\GetSuppliers\GetSuppliersService;
use App\Application\Supplier\GetSuppliers\GetSuppliersUseCase;
use App\Application\Supplier\UpdateSupplier\UpdateSupplierService;
use App\Application\Supplier\UpdateSupplier\UpdateSupplierUseCase;
use App\Domain\Supplier\SupplierRepository;
use App\Repositories\SupplierRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class SupplierProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SupplierRepository::class, SupplierRepositoryImpl::class);
        $this->app->singleton(GetSuppliersUseCase::class, GetSuppliersService::class);
        $this->app->singleton(GetSupplierUseCase::class, GetSupplierService::class);
        $this->app->singleton(CreateSupplierUseCase::class, CreateSupplierService::class);
        $this->app->singleton(UpdateSupplierUseCase::class, UpdateSupplierService::class);
        $this->app->singleton(DeleteSupplierUseCase::class, DeleteSupplierService::class);
    }
}
