<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\Search as Model;
use App\Models\Navigation\SearchRecord;
use Carbon\Carbon;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Search extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $limitCacheKey = 'search_limit_ten';

    public static function createSearches($keywords, $ip = '')
    {
        $word = Model::where('keyword','=',$keywords)->first();
        if ($word) {
            Model::where('keyword','=',$keywords)->increment('num');
        } else {
            $word = Model::create([
                'keyword' => $keywords,
                'num' => 1,
                'status' => 1,
            ]);
        }
        DB::table(SearchRecord::getRecordTableName())->insert([
            'search_id' => $word->id,
            'keyword' => $keywords,
            'created_at' => Carbon::now(),
            'ip' => $ip,
        ]);
        Cache::forget(self::$limitCacheKey);
    }

    public static function getLimitTen()
    {
        if (!Cache::has(self::$limitCacheKey)) {
            $res = Model::where('is_hot','=',1)->where('status', 1)->orderBy('order','desc')->orderBy('num', 'desc')->limit(10)->get()->toArray();
            if (count($res) < 10) {
                $resTwo = Model::where('is_hot','=',0)->where('status', 1)->orderBy('order','desc')->orderBy('num', 'desc')->limit((10-count($res)))->get()->toArray();
                $res = array_merge($res, $resTwo);
            }
            // 保存24小时
            Cache::put(self::$limitCacheKey, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$limitCacheKey);
        }
        return json_decode(json_encode($res));
    }
}
