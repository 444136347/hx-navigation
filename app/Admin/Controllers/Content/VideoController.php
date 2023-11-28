<?php

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Content\Video;
use App\Models\Content\Video as VideoModel;
use App\Models\Navigation\Site;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class VideoController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Video(), function (Grid $grid) {
            $grid->model()->with(['user']);
            $grid->column('id')->sortable();
            $grid->column('cover_at')->display(function () {
                return $this->getCoverAt();
            })->image('',100,100);
            $grid->column('title');
            $grid->column('sub_title');
            $grid->column('video_at')->view('admin.fields.list.video');
            $grid->column('seconds','视频时长')->display(function ($seconds) {
                 return "<span>" . gmdate("H:i:s",ceil($seconds)). "</span>";
            });

            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->column('user.name', '创建者');
            $grid->status()->switch('', true);
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(4);
                $filter->like('title')->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(VideoModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(VideoModel::class));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Video::with(['user']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('sub_title');
            $show->field('cover_at')->view('admin.fields.detail.image');
            $show->field('video_at')->view('admin.fields.list.video');;
            $show->field('seconds');
            $show->field('description');
            $show->field('user.name','创建者');
            $show->status()->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Video(), function (Form $form) {
            $form->model()->with(['user']);

            $form->display('id');
            $form->text('title')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:videos,title';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '视频标题不能为空',
                'unique' => '视频标题已存在',
                'min' => '视频标题字节最小为1',
                'max' => '视频标题字节最大为32',
            ])->required();
            $form->text('sub_title')->rules('required|min:1|max:64',[
                'required' => '视频副标题不能为空',
                'min' => '视频副标题字节字节最小为1',
                'max' => '视频副标题字节最大为255',
            ])->required();
            $form->textarea('description')->rules('max:255',[
                'max' => '视频副标题字节最大为255',
            ])->required();
            $form->image('cover_at')->required()
                ->rules('image')
                ->autoUpload()
                ->autoSave(false)
                ->removable(false)
                ->accept('jpg,png,gif,jpeg', 'image/*')
                ->help('目前上传格式支持：jpg,png,gif,jpeg，最大为'.(getCiSize()/1024).'M')
                ->maxSize(getCiSize())
                ->disk(getDisk())
                ->saveFullUrl(whetherSaveFullUrl());
            $form->file('video_at')->required()
                ->autoUpload()
                ->autoSave(false)
                ->removable(false)
                ->accept('mp4')
                ->maxSize(getCvSize())
                ->help('目前上传格式支持：mp4，最大为'.(getCvSize()/1024).'M')
                ->disk(getDisk())
                ->saveFullUrl(whetherSaveFullUrl());
            $form->switch('status')->default(1);
            $form->hidden('user_id');
            $form->hidden('seconds')->default(0);
            $form->saving(function (Form $form){
                $form->seconds = Video::getVideoSecond($form);
                $form->user_id = Admin::user()->getKey();
            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function search()
    {
        $videos = VideoModel::where('status',1)->when(request('query'), function ($query, $value) {
            $query->where('title', 'like', "%{$value}%");
        })->get();

        return Admin::json($videos->toArray());
    }

    /**
     * 重写删除方法
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Site::where('content_type',3)->where('content_id',$id)->count()) {
            return $this->form()->response()->error('无法删除，该视频已被关联，请先移除关联');
        }
        return $this->form()->destroy($id);
    }
}
