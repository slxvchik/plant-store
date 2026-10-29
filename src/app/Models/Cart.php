<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Cart\Model\Cart as DomainCartModel;
use App\Domain\Cart\Model\CartLine;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * @property string $id
 * @property int|null $user_id
 * @property Carbon $updated_at
 */
class Cart extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function toDomain(): DomainCartModel
    {
        /** @var array<string, array<string, CartLine>> $cartLines */
        $cartLines = [];

        $rows = DB::table('cart_lines')->where('cart_id', $this->id)->get();

        /** @var stdClass $row */
        foreach ($rows as $row) {
            $cartLines[$row->product_id][$row->offer_id] = new CartLine(
                productId: (string) $row->product_id,
                offerId: (string) $row->offer_id,
                quantity: (int) $row->quantity,
            );
        }

        return DomainCartModel::fromDb(
            id: $this->id,
            userId: $this->user_id !== null ? (string) $this->user_id : null,
            cartLines: $cartLines,
            updated: DateTimeImmutable::createFromInterface($this->updated_at),
        );
    }
}
