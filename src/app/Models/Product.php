<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Product\Model\Product as DomainProduct;
use App\Domain\Shared\SortedItem\SortedItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * @property string $id
 * @property bool $active
 * @property string $alias
 * @property int $sort
 * @property string $name
 * @property ?string $description
 * @property Collection<int, Offer> $offers
 */
class Product extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'active',
        'alias',
        'sort',
        'name',
        'description',
    ];

    protected $casts = [
        'alias' => 'string',
        'active' => 'boolean',
        'sort' => 'integer',
    ];

    public function toDomain(): DomainProduct
    {
        $categoryIds = DB::table('product_categories')->where('product_id', $this->id)->pluck('category_id')->toArray();
        $tagIds = DB::table('product_tags')->where('product_id', $this->id)->pluck('tag_id')->toArray();
        $imageIds = DB::table('product_images')
            ->where('product_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row): SortedItem => new SortedItem(
                id: $row->image_id,
                sort: (int) $row->sort,
            ))
            ->all();
        $videoIds = DB::table('product_videos')
            ->where('product_id', $this->id)
            ->orderBy('sort')
            ->get()
            ->map(fn (stdClass $row): SortedItem => new SortedItem(
                id: $row->video_id,
                sort: (int) $row->sort,
            ))
            ->all();

        return DomainProduct::fromDb(
            id: $this->id,
            active: $this->active,
            alias: $this->alias,
            sort: $this->sort,
            name: $this->name,
            description: $this->description,
            categories: $categoryIds,
            tags: $tagIds,
            videoIds: $videoIds,
            imageIds: $imageIds,
            offers: $this->offers->mapWithKeys(fn (Offer $offer): array => [$offer->id => $offer->toDomain()])->all(),
        );
    }

    /**
     * @return BelongsToMany<Offer, $this>
     */
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
