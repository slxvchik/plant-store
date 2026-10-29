<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Model\Order;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Order as OrderModel;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Override;

class OrderRepositoryImpl implements OrderRepository
{
    #[Override]
    public function create(Order $order): string
    {
        OrderModel::create($this->attributes($order));
        $this->syncLines($order);

        return $order->id->value;
    }

    #[Override]
    public function update(Order $order): void
    {
        $model = OrderModel::findOrFail($order->id->value);
        $model->update($this->attributes($order));
        $this->syncLines($order);
    }

    #[Override]
    public function delete(string $id): void
    {
        OrderModel::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?Order
    {
        return OrderModel::find($id)?->toDomain();
    }

    #[Override]
    public function findByUserId(string $userId): array
    {
        return OrderModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (OrderModel $order): Order => $order->toDomain())
            ->all();
    }

    #[Override]
    public function search(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page
    {
        $query = OrderModel::query()->orderBy('created_at', 'desc');

        if ($orderSearchCriteria->userId !== null) {
            $query->where('orders.user_id', $orderSearchCriteria->userId);
        }

        if ($orderSearchCriteria->orderStatus !== null) {
            $query->where('orders.status', $orderSearchCriteria->orderStatus->value);
        }

        if ($orderSearchCriteria->productId !== null) {
            $query->whereIn('orders.id', function (QueryBuilder $subQuery) use ($orderSearchCriteria): void {
                $subQuery->select('order_id')
                    ->from('order_lines')
                    ->where('product_id', $orderSearchCriteria->productId);
            });
        }

        if ($orderSearchCriteria->productOfferId !== null) {
            $query->whereIn('orders.id', function (QueryBuilder $subQuery) use ($orderSearchCriteria): void {
                $subQuery->select('order_id')
                    ->from('order_lines')
                    ->where('product_offer_id', $orderSearchCriteria->productOfferId);
            });
        }

        if ($orderSearchCriteria->createdFrom !== null) {
            $query->where('orders.created_at', '>=', $orderSearchCriteria->createdFrom->format('Y-m-d H:i:s'));
        }

        if ($orderSearchCriteria->createdTo !== null) {
            $query->where('orders.created_at', '<=', $orderSearchCriteria->createdTo->format('Y-m-d H:i:s'));
        }

        $paginator = $query->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (OrderModel $order): Order => $order->toDomain(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(Order $order): array
    {
        return [
            'id' => $order->id->value,
            'user_id' => $order->userId,
            'status' => $order->status->value,
        ];
    }

    private function syncLines(Order $order): void
    {
        DB::table('order_lines')->where('order_id', $order->id->value)->delete();

        foreach ($order->orderLines as $orderLine) {
            DB::table('order_lines')->insert([
                'order_id' => $order->id->value,
                'product_id' => $orderLine->productId,
                'product_offer_id' => $orderLine->productOfferId,
                'quantity' => $orderLine->quantity,
                'unit_price_in_kopecks' => $orderLine->unitPriceInKopecks,
            ]);
        }
    }
}
