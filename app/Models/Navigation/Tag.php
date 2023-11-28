<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'navigation_tags';

    protected $fillable = [
        'id',
        'name', // 标题
        'user_id', // 用户分类Id
        'use_num',
        'status' // 状态, 1启用, 0禁用
    ];

    public function user()
    {
        return $this->belongsTo(config('admin.database.users_model'));
    }

    public function site()
    {
        return $this->belongsToMany(Tag::class,'navigation_site_tags','tag_id','site_id');
    }
}
