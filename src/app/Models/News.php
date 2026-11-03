<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\News\Model\News as DomainNews;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $alias
 * @property int $sort
 * @property string $name
 * @property bool $active
 * @property ?string $description
 */
class News extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'alias', 'sort', 'name', 'active', 'description'];

    protected $casts = [
        'sort' => 'integer',
        'active' => 'boolean',
    ];

    public function toDomain(): DomainNews
    {
        return DomainNews::fromDb(
            id: $this->id,
            alias: $this->alias,
            sort: $this->sort,
            name: $this->name,
            active: $this->active,
            description: $this->description,
        );
    }
}
