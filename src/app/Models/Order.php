<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Order\Model\Order as DomainOrder;
use App\Domain\Order\Model\OrderLine;
use App\Domain\Order\Model\OrderStatus;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * @property string $id
 * @property string $user_id
 * @property string $status
 * @property Carbon $created_at
 */
class Order extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'user_id', 'status'];

    public function toDomain(): DomainOrder
    {
        $orderLines = [];

        $rows = DB::table('order_lines')->where('order_id', $this->id)->get();

        /** @var stdClass $row */
        foreach ($rows as $row) {
            $orderLines[] = new OrderLine(
                productId: (string) $row->product_id,
                productOfferId: (string) $row->product_offer_id,
                quantity: (int) $row->quantity,
                unitPriceInKopecks: (int) $row->unit_price_in_kopecks,
            );
        }

        return DomainOrder::fromDb(
            id: $this->id,
            userId: (string) $this->user_id,
            status: OrderStatus::from($this->status),
            orderLines: $orderLines,
            created: DateTimeImmutable::createFromInterface($this->created_at),
        );
    }
}
