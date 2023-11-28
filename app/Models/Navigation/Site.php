<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Site extends Model
{
    use SoftDeletes;

    protected $table = 'navigation_sites';

    protected $fillable = [
        'id',
        'title',
        'url',
        'description',
        'user_id',
        'show_outside',
        'content_id',
        'content_type',
        'category_id',
        'cover_at',
        'order',
        'status' // 状态, 1启用, 0禁用
    ];

    public function user()
    {
       return $this->belongsTo(config('admin.database.users_model'));
    }

    public function category()
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'navigation_site_tags','site_id','tag_id');
    }

    public function getCoverAt()
    {
        if (Str::contains($this->cover_at, '//')) return $this->cover_at;
        return Storage::disk('admin')->url($this->cover_at);
    }
}
