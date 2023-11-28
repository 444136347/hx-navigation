<?php

namespace App\Admin\Actions\Restore;

use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BatchContentRestore extends BatchAction
{
    protected $title = '批量恢复';

    protected $model;
    protected $cacheKeys;

    // 注意构造方法的参数必须要有默认值
    public function __construct(string $model = null, $cacheKeys = [])
    {
        $this->model = $model;
        $this->cacheKeys = $cacheKeys;
    }

    public function handle(Request $request)
    {
        $model = $request->get('model');
        $cacheKeys = $request->get('cacheKeys');

        foreach ((array) $this->getKey() as $key) {
            $model::withTrashed()->findOrFail($key)->restore();
        }
        if ($cacheKeys && is_array($cacheKeys)) {
            foreach ($cacheKeys as $cacheKey) {
                Cache::forget($cacheKey);
            }
        } else if ($cacheKeys && is_string($cacheKeys)) {
            Cache::forget($cacheKeys);
        }
        return $this->response()->success('已批量恢复')->refresh();
    }

    protected function html()
    {
        $this->defaultHtmlAttribute('href', 'javascript:void(0)');

        return <<<HTML
<a {$this->formatHtmlAttributes()}><i class="fa fa-rotate-right"></i> {$this->title()}</a>
HTML;
    }

    public function confirm()
    {
        return ['确定批量恢复吗？'];
    }

    public function parameters()
    {
        return [
            'model' => $this->model,
            'cacheKeys' => $this->cacheKeys,
        ];
    }
}
