<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PictureAttachment extends Model
{
    protected $table = 'picture_attachments';

    protected $fillable = [
        'picture_id',
        'url',
        'desc',
        'order',
    ];

    public function getUrl()
    {
        if (Str::contains($this->url, '//')) {
            return $this->url;
        }

        return Storage::disk('admin')->url($this->url);
    }
}
