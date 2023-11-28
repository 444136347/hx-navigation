<?php

namespace App\Models\Navigation;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\ModelTree;

class SiteCategory extends Model
{
    use ModelTree;

    protected $table = 'navigation_site_categories';

    protected $depthColumn = 'depth';

    protected $fillable = [
        'id',
        'parent_id',
        'depth',
        'title', // 标题
        'user_id', // 用户分类Id
        'icon',
        'order',
        'description',
        'status' // 状态, 1启用, 0禁用
    ];

    public function user()
    {
        return $this->belongsTo(config('admin.database.users_model'));
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function site()
    {
        return $this->hasMany(Site::class,'category_id','id');
    }
}
