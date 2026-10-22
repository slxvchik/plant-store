<?php

namespace App\Models;

use App\Domain\Product\Model\Product as DomainProductModel;
use App\Domain\Shared\SortedItem\SortedItem;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use stdClass;

class Product extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function toDomain(): DomainProductModel
    {
        $categoryIds = DB::table('product_categories')->where('product_id', $this->id)->pluck('category_id')->toArray();
        $tagIds = DB::table('product_tags')->where('product_id', $this->id)->pluck('tag_id')->toArray();
        $imageIds = DB::table('product_images')
            ->where('product_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row) => new SortedItem(
                id: $row->image_id,
                sort: (int) $row->sort,
            ))
            ->toArray();
        $videoIds = DB::table('product_videos')
            ->where('product_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row) => new SortedItem(
                id: $row->video_id,
                sort: (int) $row->sort,
            ))
            ->toArray();

        return DomainProductModel::fromDb(
            id: $this->id,
            active: $this->active,
            alias: $this->alias,
            sort: $this->sort,
            name: $this->name,
            description: $this->description ?? null,
            categories: $categoryIds,
            tags: $tagIds,
            videoIds: $videoIds,
            imageIds: $imageIds,
            offers: $this->offers->map(fn (Offer $offer) => $offer->toDomain())->toArray(),
        );
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(
            Offer::class,
            'product_offers',
            'product_id',
            'offer_id',
        );
    }
}
