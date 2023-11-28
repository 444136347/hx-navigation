<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'sub_title',
        'description',
        'status',
        'video_at',
        'seconds',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(config('admin.database.users_model'));
    }

    public function getCoverAt()
    {
        if (Str::contains($this->cover_at, '//')) return $this->cover_at;
        return Storage::disk('admin')->url($this->cover_at);
    }

    public function getVideoAt()
    {
        if (Str::contains($this->video_at, '//')) return $this->video_at;
        return Storage::disk('admin')->url($this->video_at);
    }
}
