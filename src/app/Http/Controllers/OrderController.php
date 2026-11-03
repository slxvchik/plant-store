<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Order\CancelOrder\CancelOrderUseCase;
use App\Application\Order\CompleteOrder\CompleteOrderUseCase;
use App\Application\Order\CreateOrderForUser\CreateOrderForUserUseCase;
use App\Application\Order\DeleteOrder\DeleteOrderUseCase;
use App\Application\Order\GetOrder\GetOrderUseCase;
use App\Application\Order\GetOrders\GetOrdersUseCase;
use App\Application\Order\TakeOrderIntoWork\TakeOrderIntoWorkUseCase;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\PaginationRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class OrderController extends Controller
{
    public function __construct(
        private readonly GetOrdersUseCase $getOrdersUseCase,
        private readonly GetOrderUseCase $getOrderUseCase,
        private readonly CreateOrderForUserUseCase $createOrderForUserUseCase,
        private readonly TakeOrderIntoWorkUseCase $takeOrderIntoWorkUseCase,
        private readonly CancelOrderUseCase $cancelOrderUseCase,
        private readonly CompleteOrderUseCase $completeOrderUseCase,
        private readonly DeleteOrderUseCase $deleteOrderUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $ordersPage = $this->getOrdersUseCase->execute(
            $request->toPageable(),
            new OrderSearchCriteria,
        );

        return Inertia::render('admin/Orders', [
            'ordersPage' => new PageResponseDto($ordersPage, $request->fullUrl()),
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $this->createOrderForUserUseCase->execute($request->toUserId());

        return redirect()->back()->with(Notification::flash('Заказ успешно создан.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/OrderShow', [
            'order' => $this->getOrderUseCase->execute($id),
        ]);
    }

    public function take(string $id): RedirectResponse
    {
        $this->takeOrderIntoWorkUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Заказ взят в обработку.'));
    }

    public function cancel(string $id): RedirectResponse
    {
        $this->cancelOrderUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Заказ отменён.'));
    }

    public function complete(string $id): RedirectResponse
    {
        $this->completeOrderUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Заказ завершён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteOrderUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Заказ успешно удалён.'));
    }
}
