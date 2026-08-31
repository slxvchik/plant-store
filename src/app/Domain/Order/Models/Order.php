<?php

declare(strict_types=1);

namespace App\Domain\Order\Models;

use App\Domain\Product\Exceptions\OrderLineEmptyException;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class Order
{
    private(set) final Uuid $id;
    private(set) final string $userId;
    /**
     * @var OrderLine[]
     */
    private(set) final array $orderLines {
        set {
            if (empty($value)) {
                throw new OrderLineEmptyException();
            }
            $this->orderLines = $value;
        }
    }
    private(set) final DateTimeImmutable $created;

    /**
     * @param OrderLine[] $orderLines
     */
    private function __construct(Uuid $id, string $userId, array $orderLines, DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->orderLines = $orderLines;
        $this->created = $created;
    }

    /**
     * @param OrderLine[] $orderLines
     */
    public static function fromDb(string $id, string $userId, array $orderLines, DateTimeImmutable $created): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            userId: $userId,
            orderLines: $orderLines,
            created: $created
        );
    }

    /**
     * @param OrderLine[] $orderLines
     */
    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, string $userId, array $orderLines): self
    {
        $uuidStr = $uuidGeneratorInterface->generate();
        $uuid = new Uuid($uuidStr);
        return new self(
            id: $uuid,
            userId: $userId,
            orderLines: $orderLines,
            created: new DateTimeImmutable()
        );
    }

    /**
     * @return int total order price in kopecks
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;
        
        foreach ($this->orderLines as $orderLine) {
            $totalPrice += $orderLine->getTotalPrice();
        }
        
        return $totalPrice;
    }
}
