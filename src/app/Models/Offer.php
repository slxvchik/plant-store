<?php

namespace App\Models;

use App\Domain\Product\Model\Offer as DomainOfferModel;
use App\Domain\Product\Model\Stock;
use App\Domain\Shared\SortedItem\SortedItem;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use stdClass;

class Offer extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
        'price' => 'integer',
        'age_in_months' => 'integer',
        'sowing_date' => 'immutable_datetime',
    ];

    /**
     * @throws DateMalformedStringException
     * @throws InvalidArgumentException
     */
    public function toDomain(): DomainOfferModel
    {
        $stocks = DB::table('offer_stocks')
            ->get()
            ->map(fn (stdClass $stock) => new Stock(
                warehouseId: $stock->warehouse_id,
                quantity: $stock->quantity,
                reserved: $stock->reserved,
            ))
            ->toArray();
        $imageIds = DB::table('offer_images')
            ->where('offer_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row) => new SortedItem(
                id: $row->image_id,
                sort: (int) $row->sort,
            ))
            ->toArray();
        $videoIds = DB::table('offer_videos')
            ->where('offer_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row) => new SortedItem(
                id: $row->video_id,
                sort: (int) $row->sort,
            ))
            ->toArray();

        return new DomainOfferModel(
            id: $this->id,
            active: $this->active,
            sku: $this->sku,
            sort: $this->sort,
            description: $this->description ?? null,
            price: $this->price,
            stocks: $stocks,
            formFactor: $this->form_factor ?? null,
            size: $this->size ?? null,
            age: $this->age_in_months ?? null,
            sowingDate: $this->sowing_date ?? null,
            imageIds: $imageIds,
            videoIds: $videoIds,
        );
    }
}
