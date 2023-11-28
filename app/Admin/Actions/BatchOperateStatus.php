<?php

namespace App\Admin\Actions;

use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;

class BatchOperateStatus extends BatchAction
{
    protected $title = '批量操作状态';

    protected $model;

    protected $status;

    // 注意构造方法的参数必须要有默认值
    public function __construct(string $title, string $model = null, int $status = 1)
    {
        $this->title = $title;
        $this->model = $model;
        $this->status = $status;
    }

    public function handle(Request $request)
    {
        $model = $request->get('model');

        foreach ((array) $this->getKey() as $key) {
            $action = $model::findOrFail($key);
            $action->status = 1;
            $action->save();
        }
        if ($this->status == 1) {
            $successText = '已成功批量开启状态！';
        } else {
            $successText = '已成功批量关闭状态！';
        }
        return $this->response()->success($successText)->refresh();
    }

    protected function html()
    {
        $this->defaultHtmlAttribute('href', 'javascript:void(0)');

        if ($this->status) {
            return <<<HTML
<a {$this->formatHtmlAttributes()}><i class="fa fa-check"></i> {$this->title()}</a>
HTML;
        }
        return <<<HTML
<a {$this->formatHtmlAttributes()}><i class="fa fa-close"></i> {$this->title()}</a>
HTML;

    }

    public function confirm()
    {
        if ($this->status == 1) {
            return ['确定批量开启状态吗？'];
        } else {
            return ['确定批量关闭状态吗？'];
        }
    }

    public function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }
}
