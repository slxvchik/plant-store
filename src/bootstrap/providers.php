<?php

use App\Providers\AppServiceProvider;
use App\Providers\CartProvider;
use App\Providers\CategoryProvider;
use App\Providers\ImageProvider;
use App\Providers\MainPageGalleryProvider;
use App\Providers\NewsProvider;
use App\Providers\OrderProvider;
use App\Providers\ProductProvider;
use App\Providers\TagProvider;
use App\Providers\UserProvider;
use App\Providers\WarehouseProvider;

return [
    AppServiceProvider::class,
    CartProvider::class,
    CategoryProvider::class,
    ImageProvider::class,
    MainPageGalleryProvider::class,
    NewsProvider::class,
    OrderProvider::class,
    ProductProvider::class,
    TagProvider::class,
    UserProvider::class,
    WarehouseProvider::class,
];
