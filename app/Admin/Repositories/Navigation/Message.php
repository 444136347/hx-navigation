<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\Message as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class Message extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $allCacheKey = 'navigation_message_all';

    public static function getAll()
    {
        if (!Cache::has(self::$allCacheKey)) {
            $res = Model::where('status', 1)->orderBy('order', 'desc')->get();
            // 保存24小时
            Cache::put(self::$allCacheKey, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$allCacheKey);
        }
        return $res;
    }
}
