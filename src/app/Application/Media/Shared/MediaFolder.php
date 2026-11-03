<?php

namespace App\Application\Media\Shared;

enum MediaFolder: string
{
    case PRODUCT_IMAGES = '/product/images/';
    case PRODUCT_VIDEOS = '/product/videos/';
    case OTHER = '/other/';
}
