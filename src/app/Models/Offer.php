<?php

namespace App\Models;

use App\Domain\Product\Model\OfferModel as DomainOfferModel;
use App\Domain\ProductUnit\Model\ProductStockModel;
use App\Domain\Shared\SortedItem\SortedItem;
use DateMalformedStringException;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use stdClass;

class Offer extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'active',
        'sku',
        'name',
        'sort',
        'description',
        'price',
        'stock_quantity',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
        'price' => 'integer',
        'stock_quantity' => 'integer',
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function toDomain(): DomainOfferModel
    {
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
            name: $this->name,
            sort: $this->sort,
            description: $this->description ?? null,
            price: $this->price,
            stockQuantity: $this->stock_quantity ?? 0,
            imageIds: $imageIds,
            videoIds: $videoIds,
        );
    }
}
