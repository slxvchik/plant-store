<?php

declare(strict_types=1);

namespace App\Application\Order\TakeOrderIntoWork;

use App\Application\Order\Shared\Exception\OrderNotFoundException;
use App\Domain\Order\Repository\OrderRepository;
use Override;

readonly class TakeOrderIntoWorkService implements TakeOrderIntoWorkUseCase
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    #[Override]
    public function execute(string $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);
        if ($order === null) {
            throw new OrderNotFoundException();
        }

        $order->takeInWork();

        $this->orderRepository->update($order);
    }
}
