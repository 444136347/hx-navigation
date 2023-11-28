<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\Tag as Model;
use App\Models\Navigation\Tag as TagModel;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class Tag extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $limitCacheKey = 'tag_limit_ten';

    public static function getTagAllSelect()
    {
        return TagModel::all(['id','name'])->pluck('name', 'id');
    }

    public static function getLimitTen()
    {
        if (!Cache::has(self::$limitCacheKey)) {
            $res = Model::where('status', 1)->orderBy('use_num', 'desc')->limit(10)->get();
            // 保存24小时
            Cache::put(self::$limitCacheKey, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$limitCacheKey);
        }
        return $res;
    }

    public static function getTagString($list):array
    {
        foreach ($list as &$l) {
            $tagString = '';
            if (!empty($l['tags'])) {
                foreach ($l['tags'] as $tag) {
                    $tagString .= ($tag['name'].',');
                }
            }
            $l['tagString'] = trim($tagString,',');
        }
        return $list;
    }
}
