<?php

declare(strict_types=1);

namespace App\Domain\Order\Criteria;

use App\Domain\Order\Model\OrderStatus;
use DateTimeImmutable;

final readonly class OrderSearchCriteria
{
    public function __construct(
        public ?string $userId = null,
        public ?string $productId = null,
        public ?string $productOfferId = null,
        public ?OrderStatus $orderStatus = null,
        public ?DateTimeImmutable $createdFrom = null,
        public ?DateTimeImmutable $createdTo = null,
    ) {}
}
