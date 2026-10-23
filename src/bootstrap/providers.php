<?php

use App\Providers\AppServiceProvider;
use App\Providers\CategoryProvider;
use App\Providers\ImageProvider;
use App\Providers\ProductProvider;
use App\Providers\TagProvider;
use App\Providers\WarehouseProvider;

return [
    AppServiceProvider::class,
    CategoryProvider::class,
    ImageProvider::class,
    ProductProvider::class,
    TagProvider::class,
    WarehouseProvider::class,
];
