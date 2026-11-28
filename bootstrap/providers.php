<?php

use App\Providers\AppServiceProvider;
use App\Providers\CategoryProvider;
use App\Providers\ImageProvider;
use App\Providers\MainPageGalleryProvider;
use App\Providers\NewsProvider;
use App\Providers\ProductProvider;
use App\Providers\ProductSupplyProvider;
use App\Providers\ProductUnitProvider;
use App\Providers\ProductUnitStatusProvider;
use App\Providers\SupplierProvider;
use App\Providers\TagProvider;
use App\Providers\UserProvider;
use App\Providers\UserRequestsProvider;
use App\Providers\WarehouseProvider;

return [
    AppServiceProvider::class,
    CategoryProvider::class,
    ImageProvider::class,
    MainPageGalleryProvider::class,
    NewsProvider::class,
    ProductProvider::class,
    ProductSupplyProvider::class,
    ProductUnitProvider::class,
    ProductUnitStatusProvider::class,
    SupplierProvider::class,
    TagProvider::class,
    UserProvider::class,
    UserRequestsProvider::class,
    WarehouseProvider::class,
];
