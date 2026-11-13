<?php

namespace App\Domain\ProductUnitStatus;

use App\Domain\Shared\Uuid\Uuid;

class ProductUnitStatusModel
{
    public private(set) Uuid $id;
    public private(set) string $name;
    public private(set) ?string $comment;
}
