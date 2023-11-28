<?php

namespace App\Admin\Actions\Tree;

use Dcat\Admin\Tree\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ChangeStatus extends RowAction
{
    protected $table;

    protected $cacheKeys;

    // 注意构造方法的参数必须要有默认值
    public function __construct($table = null, $cacheKeys = [])
    {
        $this->table = $table;
        $this->cacheKeys = $cacheKeys;
    }

    public function handle(Request $request)
    {
    	$key = $this->getKey();
        $table = $request->get('table');
        $cacheKeys = $request->get('cacheKeys');
        if ($key && $table) {
            $data = DB::table($table)->where('id',$key)->first();
            DB::table($table)->where('id',$key)->update(['status' => !$data->status]);
            if ($cacheKeys && is_array($cacheKeys)) {
                foreach ($cacheKeys as $cacheKey) {
                    Cache::forget($cacheKey);
                }
            } else if ($cacheKeys && is_string($cacheKeys)) {
                Cache::forget($cacheKeys);
            }
            return $this->response()
                ->success('更新状态成功')
                ->refresh();
        }
        return $this->response()
            ->error('更新状态失败');
    }

    public function title()
    {
        return '<span style="padding-right: 5px"><i class="fa fa-exchange"></i></span>';
    }

	public function confirm()
	{
		 return ['状态变更提示!', '确定是否更改当前状态?'];
	}

    protected function authorize($user): bool
    {
        return true;
    }

    public function parameters()
    {
        return [
            'table' => $this->table,
            'cacheKeys'  => $this->cacheKeys,
        ];
    }
}
