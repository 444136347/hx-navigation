<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'sub_title',
        'cover_at',
        'description',
        'content_id',
        'status',
        'user_id',
    ];

    public function getCoverAt()
    {
        if (Str::contains($this->cover_at, '//')) return $this->cover_at;
        return Storage::disk('admin')->url($this->cover_at);
    }

    public function user()
    {
        return $this->belongsTo(config('admin.database.users_model'));
    }

    public function content()
    {
        return $this->hasOne(ArticleContent::class,'id', 'content_id');
    }
}
