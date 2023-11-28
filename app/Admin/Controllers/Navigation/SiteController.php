<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Renderable\Content\ArticleTable;
use App\Admin\Renderable\Content\PictureTable;
use App\Admin\Renderable\Content\VideoTable;
use App\Admin\Repositories\Navigation\Category as CategoryRepositories;
use App\Admin\Repositories\Navigation\Site;
use App\Admin\Repositories\Navigation\Tag;
use App\Models\Content\Article;
use App\Models\Content\Picture;
use App\Models\Content\Video;
use App\Models\Navigation\Site as SiteModel;
use App\Models\Navigation\SiteCategory;
use App\Models\Navigation\Tag as TagModel;
use Carbon\Carbon;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Site(), function (Grid $grid) {
            $grid->model()->with(['user','category','tags']);

            $grid->column('id')->sortable();
            $grid->column('cover_at')->display(function () {
                return $this->getCoverAt();
            })->image('',100,100);
            $grid->column('title');
            $grid->column('category.title','分类');
            $grid->column('order')->editable(true);
            $grid->column('content_type')->display(function ($type) {
                return "<span>".Site::$contentTypeArr[$type]."</span>";
            });
            $grid->column('content_id','关联内容标题')->display(function ($id)use ($grid) {
                return '<span>'.(Site::getContent($this->content_type, $id)->title ?? '暂无' ).'</span>';

            });
            $grid->column('user.name', '创建者');
            $grid->column('tags')->display(function ($tags) {
                $str = '';
                $tags->each(function($tag)use (&$str) {$str .= ($tag->name .'；');});
                return trim($str,'；');
            });
            $grid->status()->switch('', true);
            $grid->show_outside()->switch('', true);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();

                // 注意切换为panel布局方式时需要重新调整表单字段的宽度
                $filter->equal('id')->width(4);
                $filter->like('title')->width(4);
                $filter->in('content_type')->multipleSelect(Site::$contentTypeArr)->width(4);
                $filter->equal('category.parent_id','上级分类')->select(CategoryRepositories::getParentCategory())
                    ->load('category_id', '/navigation/category/allSearch')->width(4);
                $filter->equal('category_id')->select('/navigation/category/allSearch')->width(4)->value(request('category_id'));
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(SiteModel::class,[
                        CategoryRepositories::$categoryWithSiteKey
                    ]));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(SiteModel::class,[
                        CategoryRepositories::$categoryWithSiteKey
                    ]));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Site::with(['user','category','tags']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('cover_at')->view('admin.fields.detail.image');
            $show->field('url');
            $show->field('category.title','分类');
            $show->field('description');
            $show->field('content_type')->unescape()->as(function ($type) {
                return '<div>'.Site::$contentTypeArr[$type].'</div>';
            });
            $show->field('content_id','关联内容标题')->unescape()->as(function ($id) use($show) {
                return '<div>'.(Site::getContent($show->model()->content_type, $id)->title ?? '暂无' ).'</div>';
            });
            $show->field('order');
            $show->field('tags')->as(function ($tags){
                $str = '';
                foreach ($tags as $tag) {
                    $str .= ($tag['name'] .'；');
                }
                return trim($str,'；');
            });
            $show->status()->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('show_outside')->unescape()->as(function ($show_outside) {
                return $show_outside ? '<div>开启</div>' : '<div>关闭</div>';
            });
            $show->field('user.name','创建者');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Site(), function (Form $form){
            $data = CategoryRepositories::getParentCategory();
            $form->model()->with(['user','tags']);
            $form->ignore(['tags','parent']);

            $form->display('id');
            $parent = $form->select('parent', '上级分类')->options($data)
                ->load('category_id', '/navigation/category/allSearch')->required();
            if ($form->isEditing()) {
                // 设置分类数据
                $category = SiteCategory::where('id',$form->model()->category_id)->first();
                $parent->value($category->parent_id);
            }

            $form->select('category_id')->required()->value($form->model()->category_id);
            $form->text('title')->rules(function (Form $form) {
                    // 如果不是编辑状态，则添加字段唯一验证
                    if (!$id = $form->model()->id) {
                        return 'required|min:1|max:255|unique:navigation_sites,title';
                    }
                    return 'required|min:1|max:255';
            },[
                    'required' => '标题不能为空',
                    'unique' => '标题已存在',
                    'min' => '标题字节字节最小为1',
                    'max' => '标题字节最大为255',
            ])->required();
            $form->image('cover_at')->required()
                ->autoUpload()
                ->autoSave(false)
                ->removable(false)
                ->accept('jpg,png,gif,jpeg', 'image/*')
                ->help('目前上传格式支持：jpg,png,gif,jpeg，最大为'.(getCiSize()/1024).'M')
                ->maxSize(getCiSize())
                ->disk(getDisk())
                ->saveFullUrl(whetherSaveFullUrl());

            $form->url('url')->rules('required|url|max:255',[
                'required' => 'url不能为空',
                'url' => '请输入正确格式的url',
                'max' => 'url字节最大为255',
            ])->required();
            $form->textarea('description')->rules('min:1|max:255',[
                'min' => '描述字节字节最小为1',
                'max' => '描述字节最大为255',
            ])->required();
            $form->radio('content_type')->options(Site::$contentTypeArr)
                ->when(1,function (Form $form) {
                    $form->selectTable('article_content_id','文章关联')
                        ->title('文章列表')
                        ->placeholder('请点击↑选择文章')
                        ->setLabelClass(['asterisk']) // 显示 * 号
                        ->dialogWidth('50%') // 弹窗宽度，默认 800px
                        ->from(ArticleTable::make(['id' => $form->model()->content_id])) // 设置渲染类实例，并传递自定义参数
                        ->model(Article::class, 'id', 'title')
                        ->value($form->model()->content_type == 1 ? $form->model()->content_id : ''); // 设置编辑数据显示
                })
                ->when(2,function (Form $form) {
                    $form->selectTable('picture_content_id','图集关联')
                        ->title('图集列表')
                        ->placeholder('请点击↑选择图集')
                        ->setLabelClass(['asterisk']) // 显示 * 号
                        ->dialogWidth('50%') // 弹窗宽度，默认 800px
                        ->from(PictureTable::make(['id' => $form->model()->content_id])) // 设置渲染类实例，并传递自定义参数
                        ->model(Picture::class, 'id', 'title')
                        ->value($form->model()->content_type == 2 ? $form->model()->content_id : ''); // 设置编辑数据显示
                })
                ->when(3,function (Form $form) {
                    $form->selectTable('video_content_id','视频关联')
                        ->title('视频列表')
                        ->placeholder('请点击↑选择视频')
                        ->setLabelClass(['asterisk']) // 显示 * 号
                        ->dialogWidth('50%') // 弹窗宽度，默认 800px
                        ->from(VideoTable::make(['id' => $form->model()->content_id])) // 设置渲染类实例，并传递自定义参数
                        ->model(Video::class, 'id', 'title')
                        ->value($form->model()->content_type == 3 ? $form->model()->content_id : ''); // 设置编辑数据显示
                })
                ->default(0);
            $form->number('order')->default(0);
            $ms = $form->multipleSelect('tags')
                ->options(Tag::getTagAllSelect());
            if($form->isEditing()) {
                $tags = $form->model()->tags ? $form->model()->tags->toArray() : [];
                $ms->value(array_column($tags, 'id'));
            }

            $form->switch('status')->default(1);
            $form->switch('show_outside')->default(0);
            $form->hidden('user_id');
            $form->hidden('content_id');

            $aci = $form->article_content_id;
            $pci = $form->picture_content_id;
            $vci = $form->video_content_id;
            $form->ignore(['article_content_id','picture_content_id','video_content_id']);
            $form->saving(function (Form $form) use($aci,$pci,$vci){
                $form->content_id = 0;
                if ($form->content_type == 1) {
                    if (!$aci) {
                        return $form->response()->error('关联文章不能为空');
                    }
                    $form->content_id = $aci;
                } else if ($form->content_type == 2) {
                    if (!$pci) {
                        return $form->response()->error('关联图集不能为空');
                    }
                    $form->content_id = $pci;
                } else if ($form->content_type == 3) {
                    if (!$vci) {
                        return $form->response()->error('关联图集视频不能为空');
                    }
                    $form->content_id = $vci;
                }

                $form->user_id = Admin::user()->getKey();
            });

            $ft = $form->tags;
            $form->saved(function (Form $form) use ($ft) {
                $tagsIdArray = $form->model()->tags ? $form->model()->tags->pluck('id')->toArray() : [];
                $id = $form->getKey();
                $insertData = [];$insertDataIds = [];$deleteDataIds = [];
                if (!is_null($tagsIdArray) && !is_null($ft)) {
                    $tagRes = array_merge(array_diff($tagsIdArray, $ft), array_diff($ft, $tagsIdArray));
                    foreach ($tagRes as $k => $tag) {
                        if ($tag) {
                            if ($form->isEditing() && in_array($tag, $tagsIdArray)) {
                                array_push($deleteDataIds, $tag);
                                continue;
                            }
                            array_push($insertData, ['tag_id' => $tag, 'site_id' => $id, 'created_at' => Carbon::now()]);
                            array_push($insertDataIds, $tag);
                        }
                    }
                }
                if(count($insertData) > 0) {
                    DB::table('navigation_tags')->whereIn('id',$insertDataIds)->increment('use_num');
                    DB::table('navigation_site_tags')->insert($insertData);
                    Cache::forget(Tag::$limitCacheKey);
                }
                if(count($deleteDataIds) > 0) {
                    DB::table('navigation_tags')->whereIn('id',$deleteDataIds)->decrement('use_num');
                    DB::table('navigation_site_tags')->where('site_id',$id)->whereIn('tag_id',$deleteDataIds)->delete();
                    Cache::forget(Tag::$limitCacheKey);
                }

                Cache::forget(CategoryRepositories::$categoryWithSiteKey);
            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
