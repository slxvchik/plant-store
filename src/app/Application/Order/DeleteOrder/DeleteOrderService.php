<?php

declare(strict_types=1);

namespace App\Application\Order\DeleteOrder;

use App\Application\Order\Shared\Exception\OrderNotFoundException;
use App\Domain\Order\Repository\OrderRepository;
use Override;

readonly class DeleteOrderService implements DeleteOrderUseCase
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    /**
     * @throws OrderNotFoundException
     */
    #[Override]
    public function execute(string $id): void
    {
        if ($this->orderRepository->findById($id) === null) {
            throw new OrderNotFoundException;
        }

        $this->orderRepository->delete($id);
    }
}
