<?php

namespace App\Admin\Actions;

use App\Admin\Forms\AdminSetting as AdminSettingForm;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Widgets\Modal;

class AdminSetting extends Action
{
    protected $title = '<i class="feather icon-edit" style="font-size: 1.5rem"></i> 网站设置';

    public function render()
    {
        $model = Modal::make()
            ->id('admin-setting-config') // 导航栏显示弹窗，必须固定ID，随机ID会在刷新后失败
            ->title($this->title())
            ->lg()
            ->body(AdminSettingForm::make())
            ->button(
                <<<HTML
<ul class="nav navbar-nav">
     <li class="nav-item"> &nbsp;{$this->title()} &nbsp;</li>
</ul> 
HTML
            );
        return $model->render();
    }
}
