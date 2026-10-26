<?php

declare(strict_types=1);

namespace App\Domain\News\Model;

use App\Domain\Shared\Uuid\Uuid;

class News
{
    public private(set) Uuid $id;
}
