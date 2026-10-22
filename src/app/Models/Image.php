<?php

namespace App\Models;

use App\Domain\Media\Model\Image as DomainImageModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'web_path_to_file', 'mime_type', 'size_in_bytes', 'width', 'height', 'title_text', 'alt_text'];

    public function toDomain(): DomainImageModel
    {
        return DomainImageModel::fromDb(
            id: $this->id,
            webPathToFile: $this->web_path_to_file,
            mimeType: $this->mime_type,
            sizeInBytes: (int) $this->size_in_bytes,
            width: (int) $this->width,
            height: (int) $this->height,
            titleText: $this->title_text,
            altText: $this->alt_text,
        );
    }
}
