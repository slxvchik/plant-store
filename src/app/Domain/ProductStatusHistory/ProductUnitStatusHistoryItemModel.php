<?php

namespace App\Domain\ProductStatusHistory;

use App\Domain\Shared\Uuid\Uuid;
use DateTimeImmutable;

class ProductUnitStatusHistoryItemModel
{
    public private(set) Uuid $id;
    public private(set) string $productUnitStatusId;
    public private(set) DateTimeImmutable $date;
    public private(set) ?string $comment;
}
