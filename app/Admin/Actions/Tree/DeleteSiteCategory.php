<?php

namespace App\Admin\Actions\Tree;

use Dcat\Admin\Tree\RowAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DeleteSiteCategory extends RowAction
{
    protected $cacheKeys;

    // 注意构造方法的参数必须要有默认值
    public function __construct($cacheKeys = [])
    {
        $this->cacheKeys = $cacheKeys;
    }

    public function handle(Request $request)
    {
    	$key = $this->getKey();
        $table = 'navigation_site_categories';
        $siteTable = 'navigation_sites';
        $cacheKeys = $request->get('cacheKeys');
        if ($key) {
            $data = DB::table($table)->where('id',$key)->first();
            if ($data->parent_id == 0 && DB::table($table)->where('parent_id',$key)->count()) {
                return $this->response()
                    ->error('该分类下还有子分类，无法直接删除，请先删除全部子分类');
            } else if ($data->parent_id != 0 && DB::table($siteTable)->where('category_id',$key)->count()) {
                return $this->response()
                    ->error('该分类下还有关联的网站，无法直接删除，请先删除关联的全部网站');
            }
            if (DB::table($table)->where('id',$key)->delete()) {
                if ($cacheKeys && is_array($cacheKeys)) {
                    foreach ($cacheKeys as $cacheKey) {
                        Cache::forget($cacheKey);
                    }
                } else if ($cacheKeys && is_string($cacheKeys)) {
                    Cache::forget($cacheKeys);
                }
                return $this->response()
                    ->success('删除分类成功')
                    ->refresh();
            }
        }
        return $this->response()
            ->error('删除分类失败');
    }

    public function title()
    {
        return '<span style="padding-right: 5px"><i class="fa fa-trash"></i></span>';
    }

	public function confirm()
	{
		 return ['删除提示!', '确定是否删除当前分类?'];
	}

    protected function authorize($user): bool
    {
        return true;
    }

    public function parameters()
    {
        return [
            'cacheKeys'  => $this->cacheKeys,
        ];
    }
}
