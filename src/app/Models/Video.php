<?php

namespace App\Models;

use App\Domain\Media\Model\Video as DomainVideoModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'web_path_to_file', 'mime_type', 'size_in_bytes', 'width', 'height', 'loop', 'muted', 'duration_sec', 'codec', 'thumbnail_id'];

    public function toDomain(): DomainVideoModel
    {
        return DomainVideoModel::fromDb(
            id: $this->id,
            mimeType: $this->mime_type,
            sizeInBytes: (int) $this->size_in_bytes,
            width: (int) $this->width,
            height: (int) $this->height,
            loop: (bool) $this->loop,
            muted: (bool) $this->muted,
            durationSec: (int) $this->duration_sec,
            codec: $this->codec,
            thumbnailId: $this->thumbnail_id,
        );
    }
}
