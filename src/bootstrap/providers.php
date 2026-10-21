<?php

use App\Providers\AppServiceProvider;
use App\Providers\CategoryProvider;
use App\Providers\TagProvider;
use App\Providers\WarehouseProvider;

return [
    AppServiceProvider::class,
    CategoryProvider::class,
    TagProvider::class,
    WarehouseProvider::class,
];
