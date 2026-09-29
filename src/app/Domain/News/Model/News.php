<?php

namespace App\Domain\News\Model;

use App\Domain\Shared\Uuid\Uuid;

class News
{
    private(set) Uuid $id;
    private string $alias;
}
