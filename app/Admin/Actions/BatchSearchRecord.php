<?php

namespace App\Admin\Actions;

use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Admin;

class BatchSearchRecord extends AbstractTool
{
    protected $title = '搜索日志';

    public function render()
    {
        $url = admin_url('navigation/searchRecord');
        Admin::script(
            <<<SCRIPT
$('.search-record').click(function () {
    var url = "$url";
    Dcat.reload(url);
});
SCRIPT

        );
        return  <<<HTML
<button class="btn btn-primary search-record" style="margin-right:3px">
    <i class="feather icon-log-in"></i><span class="d-none d-sm-inline">&nbsp; {$this->title}</span>
</button>
HTML;
    }

    /**
     * 动作权限判断，返回false则表示无权限，如果不需要可以删除此方法
     */
    protected function authorize($user): bool
    {
        return true;
    }
}
