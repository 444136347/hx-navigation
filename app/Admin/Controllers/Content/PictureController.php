<?php

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Content\Picture;
use App\Models\Content\Picture as PictureModel;
use App\Models\Navigation\Site;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Alert;
use Illuminate\Support\Facades\DB;

class PictureController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Picture(), function (Grid $grid) {
            $grid->model()->with(['user','attachments']);

            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('sub_title');
            $grid->column('user.name', '创建者');
            // 添加不存在的字段
            $grid->column('attachments_count','图片数')->display(function () {
                return $this->attachments()->count();
            });

            $grid->status()->switch('', true);
            $grid->column('updated_at')->sortable();

            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id')->width(4);
                $filter->like('title')->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(PictureModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(PictureModel::class));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Picture::with(['user','attachments']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('sub_title');
            $show->field('description');
            $show->field('user.name','创建者');
            $show->status()->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $attachments = $show->model()->attachments;
            if (count($attachments) > 0) {
                $html ='';
                foreach ($attachments as $at) {
                    $html .= '<div class="show-field form-group row">
                                <div class="col-sm-2 control-label">
                                    <span>图片'.($at->order + 1).'</span>
                                </div>
                                <div class="col-sm-8">
                                    <div class="box box-solid box-default no-margin box-show">
                                        <div class="box-body">
                                                <img data-action="preview-img" src="' .getFullPath($at->url).'" style="max-width:200px;max-height:200px" class="img">
                                        </div>
                                    </div>
                                </div>     
                              </div>';
                    $html .= '<div class="show-field form-group row">
                                <div class="col-sm-2 control-label">
                                    <span>图片'.($at->order + 1).'描述</span>
                                </div>
                                <div class="col-sm-8">
                                    <div class="box box-solid box-default no-margin box-show">
                                        <div class="box-body">'.($at->desc).'</div>
                                    </div>
                                </div>     
                              </div>';

                }
                $show->html($html);
            }
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Picture(), function (Form $form) {
            $pictureMaxNum = config('navigation.content_picture_max_num',9);
            $form->model()->with(['user','attachments' => function($q) { $q->orderBy('order','asc');}]);

            $formTable = $form->tab('基本设置', function (Form $form) {
                $form->display('id');
                $form->text('title')->rules(function (Form $form) {
                    // 如果不是编辑状态，则添加字段唯一验证
                    if (!$id = $form->model()->id) {
                        return 'required|min:1|max:32|unique:pictures,title';
                    }
                    return 'required|min:1|max:32';
                },[
                    'required' => '图集标题不能为空',
                    'unique' => '图集标题已存在',
                    'min' => '图集标题字节最小为1',
                    'max' => '图集标题字节最大为32',
                ])->required();
                $form->text('sub_title')->rules('required|min:1|max:64',[
                    'required' => '图集副标题不能为空',
                    'min' => '图集副标题字节字节最小为1',
                    'max' => '图集副标题字节最大为255',
                ])->required();
                $form->textarea('description')->rules('max:255',[
                    'max' => '图集副标题字节最大为255',
                ])->required();
                $form->switch('status')->default(1)->required();
                $form->hidden('user_id');
                $form->display('created_at');
                $form->display('updated_at');
            });
            for ($i = 1; $i < ($pictureMaxNum + 1); $i++) {
                $imgUrl = $this->getAttachModelValue($form, $i - 1, 'url');
                $imgDesc = $this->getAttachModelValue($form, $i - 1, 'desc');
                $title = !empty($imgUrl) ? '图片'.$i.'(存量)' : '图片'.$i;
                $formTable = $formTable->tab($title, function (Form $form) use ($i, $imgUrl, $imgDesc) {
                    $alert = Alert::make('当前为图片' . $i . '，请上传对应图片和填写图片描述。', '温馨提示')->info();
                    $form->html($alert, '');

                    $form->image('picture' . $i, '图片')
                        ->autoUpload()
                        ->autoSave(false)
                        ->removable(false)
                        ->accept('jpg,png,gif,jpeg', 'image/*')
                        ->help('目前上传格式支持：jpg,png,gif,jpeg，最大为'.(getCiSize()/1024).'M')
                        ->maxSize(getCiSize())
                        ->value($imgUrl)
                        ->disk(getDisk())
                        ->saveFullUrl(whetherSaveFullUrl());
                    $form->text('picture_desc'. $i, '描述')
                        ->value($imgDesc);
                });
            }

            $pictures = [];$ignorePic = [];$ignorePicDes = [];
            for ($i = 1;$i < ($pictureMaxNum + 1); $i++) {
                $column = 'picture'.$i;
                array_push($ignorePic, $column);
                $descColumn = 'picture_desc'.$i;
                array_push($ignorePicDes, $descColumn);
                if ($form->$column) array_push($pictures, ['url' => $form->$column, 'desc' => $form->$descColumn ?? '',]);
            }
            $form->ignore($ignorePic);
            $form->ignore($ignorePicDes);
            $form->saving(function (Form $form) use ($pictures){
                $form->user_id = Admin::user()->getKey();
                if (count($pictures) == 0) {
                    return $form->response()->error('图集图片数量不能为空');
                }
            });
            $form->saved(function (Form $form) use ($pictures) {
                $attachments = $form->model()->attachments ? $form->model()->attachments : null;
                $id = $form->getKey();
                $update = 0;
                if ($attachments && count($attachments) == count($pictures)) {
                    foreach ($attachments as $k => $attach) {
                        if ($pictures[$k]['url'] != $attachments[$k]->url || $pictures[$k]['desc'] != $attachments[$k]->desc ) {
                            $update = 1;
                            break;
                        }
                    }
                } else {
                    $update = 1;
                }
                if($update) {
                    DB::table('picture_attachments')->where('picture_id',$id)->delete();
                    foreach ($pictures as $k => &$picture) {
                        $picture['order'] = $k;
                        $picture['picture_id'] = $id;
                        $picture['created_at'] = Carbon::now();
                    }
                    DB::table('picture_attachments')->insert($pictures);
                }
            });
        });
    }

    public function search()
    {
        $pictures = PictureModel::where('status',1)->when(request('query'), function ($query, $value) {
            $query->where('title', 'like', "%{$value}%");
        })->get();

        return Admin::json($pictures->toArray());
    }

    private function getAttachModelValue($form,$key,$value)
    {
        return $form->model()->attachments && isset($form->model()->attachments[$key]) ? $form->model()->attachments[$key]->$value : '';
    }

    /**
     * 重写删除方法
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Site::where('content_type',2)->where('content_id',$id)->count()) {
            return $this->form()->response()->error('无法删除，该图集已被关联，请先移除关联');
        }
        return $this->form()->destroy($id);
    }
}
