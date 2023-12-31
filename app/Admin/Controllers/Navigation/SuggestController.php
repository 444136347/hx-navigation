<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Repositories\Navigation\Category as CategoryRepositories;
use App\Admin\Repositories\Navigation\Suggest;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\AdminController;

class SuggestController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Suggest(), function (Grid $grid) {
            $grid->model()->with(['category']);

            $grid->setName('用户投稿');
            $grid->column('id')->sortable();
            $grid->column('title','投稿标题');
            $grid->column('classify','投稿类别')->display(function ($classify) {
                 return Suggest::$classifyText[$classify];
            });
            $grid->column('category.title','站内分类（二级分类）');
            $grid->column('link');
            $grid->column('link','推荐链接')->display(function ($link) {
                if ($link) {
                    return "<a href='".$link."' target='_blank'>$link</a>";
                }
                return "<span>暂无</span>";
            });
            $grid->column('submit_ip','投稿人ip');
            $grid->status('状态')->switch('', true);
            $grid->column('created_at')->sortable();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(4);
                $filter->like('title')->width(4);
                $filter->equal('category.parent_id','上级分类')->select(CategoryRepositories::getParentCategory())
                    ->load('category_id', '/navigation/category/allSearch')->width(4);
                $filter->equal('category_id')->select('/navigation/category/allSearch')->width(4)->value(request('category_id'));
                $filter->equal('classify')->select(Suggest::$classifyText)->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

            });

            $grid->disableCreateButton();
            $grid->disableEditButton();
        });
    }

    protected function detail($id)
    {
        $model = Suggest::with(['category']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title', '投稿标题');
            $show->field('classify', '投稿类别')->unescape()->as(function ($classify) {
                return Suggest::$classifyText[$classify];
            });
            $show->field('category.title','站内分类（二级分类）');
            $show->field('link', '投稿链接');
            $show->field('description','投稿描述');
            $show->field('submit_ip','投稿人ip');
            if ($show->model()->classify == 'down') {
                $html = '';
                $dataObjs = json_decode($show->model()->data_json);
                if (!empty($dataObjs)) {
                    $keyAndData = [
                        'tougao_down_version' => '资源版本',
                        'tougao_sites_down' => '网盘链接',
                        'tougao_down_preview' => '演示链接',
                        'tougao_sites_password' => '网盘密码',
                        'tougao_down_decompression' => '解压密码',
                    ];
                    foreach ($dataObjs as $key => $ob) {
                        $html .= '<div class="show-field form-group row">
                                <div class="col-sm-2 control-label">
                                    <span>'.$keyAndData[$key].'</span>
                                </div>
                                <div class="col-sm-8">
                                    <div class="box box-solid box-default no-margin box-show">
                                        <div class="box-body">'.(!empty($ob) ? $ob : '暂无').'</div>
                                    </div>
                                </div>     
                              </div>';
                    }
                    $show->html($html);
                }
            }
            $show->status('状态')->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('created_at');
        });
    }

    protected function form()
    {
        // 可以单独关闭状态
        return Form::make(new Suggest(), function (Form $form){
            $form->display('id');
            $form->switch('status')->default(1);
        });
    }
}
