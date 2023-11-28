<?php

namespace App\Admin\Controllers\Content;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Content\Article;
use App\Models\Content\Article as ArticleModel;
use App\Models\Content\ArticleContent;
use App\Models\Navigation\Site;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class ArticleController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Article(), function (Grid $grid) {
            $grid->model()->with(['user']);

            $grid->column('id')->sortable();
            $grid->column('cover_at')->display(function () {
                return $this->getCoverAt();
            })->image('',100,100);
            $grid->column('title');
            $grid->column('sub_title');
            $grid->column('user.name', '创建者');
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
                    $actions->append(new Restore(ArticleModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(ArticleModel::class));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Article::with(['user','content']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('cover_at')->view('admin.fields.detail.image');
            $show->field('title');
            $show->field('sub_title');
            $show->field('content.content','内容')->unescape()->as(function ($content) {
                return "<div>$content</div>";
            });
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
        return Form::make(new Article(), function (Form $form) {
            $form->model()->with(['user']);
            $content = '';
            if ($form->isCreating()) {
                $content = $form->content;
            } else if($form->isEditing()) {
                $content = $form->content ?? (string)$form->model()->content->content;
            }
            $form->ignore(['content']);
            $form->display('id');
            $form->text('title')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:articles,title';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '文章标题不能为空',
                'unique' => '文章标题已存在',
                'min' => '文章标题字节最小为1',
                'max' => '文章标题字节最大为32',
            ])->required();
            $form->text('sub_title')->rules('required|min:1|max:64',[
                'required' => '文章副标题不能为空',
                'min' => '文章副标题字节字节最小为1',
                'max' => '文章副标题字节最大为255',
            ])->required();
            $form->textarea('description')->rules('max:255',[
                'max' => '文章副标题字节最大为255',
            ])->required();
            $form->image('cover_at')->required()
                ->autoUpload()
                ->autoSave(false)
                ->removable(false)
                ->accept('jpg,png,gif,jpeg', 'image/*')
                ->help('目前上传格式支持：jpg,png,gif,jpeg，最大为'.(getCiSize()/1024).'M')
                ->maxSize(getCiSize())
                ->disk(getDisk()) // 指定文件上传disk
                ->saveFullUrl(whetherSaveFullUrl()); // 设置文件上传自动拼接域名
            $form->editor('content')->required()
                ->disk(getDisk())
                ->value($content);
            $form->switch('status')->default(1);
            $form->hidden('user_id');
            $form->hidden('content_id')->default(0);
            $form->saving(function (Form $form) use ($content) {
                if ($form->content_id) {
                    $ac = ArticleContent::find($form->content_id);
                } else {
                    $ac = new ArticleContent();
                }
                $ac->content = $content;
                $ac->save();
                $form->content_id = $ac->id;
                $form->user_id = Admin::user()->getKey();
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function search()
    {
        $articles = ArticleModel::where('status',1)->when(request('query'), function ($query, $value) {
            $query->where('title', 'like', "%{$value}%");
        })->get();

        return Admin::json($articles->toArray());
    }

    /**
     * 重写删除方法
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Site::where('content_type',1)->where('content_id',$id)->count()) {
            return $this->form()->response()->error('无法删除，该文章已被关联，请先移除关联');
        }
        return $this->form()->destroy($id);
    }
}
