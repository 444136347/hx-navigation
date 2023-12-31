<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Actions\BatchSearchRecord;
use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Navigation\Search;
use App\Models\Navigation\Search as SearchModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Cache;

class SearchController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Search(), function (Grid $grid) {
            // 优先级是否热门=>排序=>搜索次数
            $grid->model()->orderBy('is_hot','desc')->orderBy('order','desc')->orderBy('num', 'desc');;
            $grid->column('id')->sortable();
            $grid->column('keyword');
            $grid->column('num')->sortable();
            $grid->column('order')->editable(true)->sortable();
            $grid->is_hot()->switch('', true);
            $grid->status()->switch('', true);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();

                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->equal('id')->width(4);
                $filter->like('keyword')->width(4);
                $filter->equal('is_hot')->select([0 => '否',1 => '是'])->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);
                $filter->month('column');

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->tools(new BatchSearchRecord());

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(SearchModel::class,[Search::$limitCacheKey]));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(SearchModel::class,[Search::$limitCacheKey]));
                }
            });
        });
    }

    protected function detail($id)
    {
        return Show::make($id, new Search(), function (Show $show) {
            $show->field('id');
            $show->field('keyword');
            $show->field('num');
            $show->field('is_hot')->unescape()->as(function ($hot) {
                return $hot ? '是' : '否';
            });
            $show->status('状态')->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('order','排序值');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Search(), function (Form $form){
            $form->display('id');
            $form->text('keyword')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:navigation_site_searches,keyword';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '搜索关键字不能为空',
                'unique' => '搜索关键字已存在',
                'min' => '搜索关键字字节最小为1',
                'max' => '搜索关键字字节最大为32',
            ])->required();
            $form->saved(function (Form $form) {
                Cache::forget(Search::$limitCacheKey);
            });
            $form->switch('is_hot')->default(1);
            $form->switch('status')->default(1);
            $form->number('order')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    /**
     * 重写删除方法
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cache::forget(Search::$limitCacheKey);
        return $this->form()->destroy($id);
    }
}
