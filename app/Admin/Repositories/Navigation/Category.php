<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\SiteCategory as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\Navigation\Site as SiteModel;
use Illuminate\Support\Facades\Cache;

class Category extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $categoryAllTree = 'navigation_category_all_tree';
    public static $categoryWithSiteKey = 'navigation_category_with_site';

    public static function getCategoryWithSite()
    {
        if (!Cache::has(self::$categoryWithSiteKey)) {
            $res = [];
            $parents = Model::where('parent_id',0)->where('status',1)->orderBy('order','asc')->get();
            foreach ($parents as $pk => &$pv) {
                $pv->site_num = SiteModel::whereIn('category_id',Model::where('parent_id',$pv->id)->pluck('id'))->count();
                $pv->children = Model::with(['site'])->where('parent_id',$pv->id)->where('status',1)->get();
                $res[$pk] = $pv;
            }
            // 保存24小时
            Cache::put(self::$categoryWithSiteKey, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$categoryWithSiteKey);
        }
        return $res;
    }

    public static function getParentCategory()
    {
        $parentCategory = Model::where('parent_id',0)->where('status',1)->select('id', 'title as text')->orderBy('order','desc')->get();
        $data = [];
        foreach ($parentCategory as $pac) {
            $data[$pac->id] = $pac->text;
        }
        return $data;
    }

    public static function getCategoryAllTree()
    {
        if (!Cache::has(self::$categoryAllTree)) {
            $parentCategory = Model::where('parent_id', 0)->where('status', 1)->select('id', 'title', 'description', 'icon')->orderBy('order', 'desc')->get();
            $res = $parentCategory->toArray();
            foreach ($res as &$pac) {
                $pac['children'] = Model::where('parent_id', $pac['id'])->where('status', 1)->select('id', 'title', 'description', 'icon')->orderBy('order', 'desc')->get()->toArray();
            }
            // 保存24小时
            Cache::put(self::$categoryAllTree, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$categoryAllTree);
        }
        return $res;
    }
}
