<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $table = 'navigation_suggests';

    protected $fillable = [
        'id',
        'title', // 标题
        'description',
        'keywords',
        'classify',
        'link',
        'submit_ip',
        'data_json',
        'category_id',
        'status' // 状态, 1启用, 0禁用
    ];

    public function category()
    {
        return $this->belongsTo(SiteCategory::class);
    }
}
