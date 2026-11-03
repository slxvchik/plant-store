<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\MainPageGallery\Model\MainPageGallery as DomainMainPageGalleryModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property int $sort
 * @property string $image_id
 * @property ?string $pre_title
 * @property ?string $title
 * @property ?string $description
 * @property ?string $button_link
 * @property ?string $button_text
 */
class MainPageGallery extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'sort',
        'image_id',
        'pre_title',
        'title',
        'description',
        'button_link',
        'button_text',
    ];

    protected $casts = [
        'sort' => 'integer',
    ];

    public function toDomain(): DomainMainPageGalleryModel
    {
        return DomainMainPageGalleryModel::fromDb(
            id: $this->id,
            sort: $this->sort,
            imageId: $this->image_id,
            preTitle: $this->pre_title,
            title: $this->title,
            description: $this->description,
            buttonLink: $this->button_link,
            buttonText: $this->button_text,
        );
    }
}
