<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Repositories\Navigation\Message;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class MessageController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Message(), function (Grid $grid) {
            $grid->model()->with(['user']);
            $grid->model()->orderBy('order','desc');
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('text');
            $grid->column('link')->display(function ($link) {
                if ($link) {
                    return "<span><a target='_blank' style='color: blue' href='$link'>$link</a></span>";
                }
                return "<span>暂无</span>";
            });
            $grid->status('状态')->switch('', true);
            $grid->column('order')->editable(true)->sortable();
            $grid->column('user.name', '创建者');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(4);
                $filter->like('title')->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);
            });
        });
    }

    protected function detail($id)
    {
        $model = Message::with(['user']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('text');
            $show->field('link');
            $show->field('description');
            $show->status('状态')->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('order','排序值');
            $show->field('user.name','创建者');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Message(), function (Form $form){
            $form->model()->with(['user']);

            $form->display('id');
            $form->text('title')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:navigation_messages,title';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '轮播标题不能为空',
                'unique' => '轮播标题已存在',
                'min' => '轮播标题字节最小为1',
                'max' => '轮播标题字节最大为32',
            ])->required();
            $form->text('text')->rules('min:1|max:255',[
                'min' => '轮播文字字节字节最小为1',
                'max' => '轮播文字字节最大为255',
            ])->required();
            $form->url('link')->rules('required|url|max:255',[
                'required' => '轮播链接不能为空',
                'url' => '请输入正确格式的url',
                'max' => '轮播链接字节最大为255',
            ])->required();
            $form->textarea('description')->rules('max:255',[
                'max' => '轮播描述字节最大为255',
            ]);
            $form->switch('status')->default(1);
            $form->number('order')->default(0);
            $form->hidden('user_id');
            $form->saving(function (Form $form) {
                $form->user_id = Admin::user()->getKey();
            });
            $form->saved(function (Form $form) {
                Cache::forget(Message::$allCacheKey);
            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
