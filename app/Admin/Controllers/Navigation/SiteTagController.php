<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Navigation\Tag;
use App\Models\Navigation\Tag as TagModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Cache;

class SiteTagController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Tag(), function (Grid $grid) {
            $grid->model()->with(['user']);
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('use_num')->sortable();
            $grid->column('user.name', '创建者');
            $grid->status()->switch('', true);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(4);
                $filter->like('name')->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(TagModel::class,[Tag::$limitCacheKey]));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(TagModel::class,[Tag::$limitCacheKey]));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Tag::with(['user']);
        return Show::make($id, $model, function (Show $show) {
            $show->model()->with(['user']);
            $show->field('id');
            $show->field('name');
            $show->status()->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('use_num');
            $show->field('user.name','创建者');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Tag(), function (Form $form) {
            $form->display('id');
            $form->text('name')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:255|unique:navigation_tags,name';
                }
                return 'required|min:1|max:255';
            },[
                'required' => '标签名称不能为空',
                'unique' => '标签名称已存在',
                'min' => '标签名称字节最小为1',
                'max' => '标签名称字节最大为255',
            ])->required();
            $form->switch('status')->default(1);
            $form->hidden('user_id');
            $form->saving(function (Form $form) {
                $form->user_id = Admin::user()->getKey();
            });
            $form->saved(function (Form $form) {
                Cache::forget(Tag::$limitCacheKey);
            });
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
        Cache::forget(Tag::$limitCacheKey);
        return $this->form()->destroy($id);
    }
}
