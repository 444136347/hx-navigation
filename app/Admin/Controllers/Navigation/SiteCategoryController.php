<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Actions\Tree\ChangeStatus;
use App\Admin\Actions\Tree\DeleteSiteCategory;
use App\Admin\Repositories\Navigation\Category;
use App\Models\Navigation\SiteCategory as CategoryModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteCategoryController extends AdminController
{
    // 模型表格
    public function index(Content $content)
    {
        $iconfontCssUrl = config('navigation.icon_font_url');
        Admin::css($iconfontCssUrl);
        return $content->header('导航分类')
            ->body(function (Row $row) {
                $tree = new Tree(new Category);
                $tree->branch(function ($branch) {
                    $src = $branch['icon'] ?? '';
                    $statusText = $branch['status'] == 0 ? '<span style="color: red">关闭</span>' : '<span style="color: dodgerblue">开启</span>';
                    $logo = "<i class='iconfont $src' style='max-width:20px;max-height:20px'/>";
                    return "$logo {$branch['title']} | 当前状态：{$statusText}";
                });
                $tree->actions([
                    new DeleteSiteCategory([
                        Category::$categoryWithSiteKey,
                        Category::$categoryAllTree
                    ]),
                    new ChangeStatus('navigation_site_categories',
                        [
                            Category::$categoryWithSiteKey,
                            Category::$categoryAllTree
                        ]
                    ),
                ]);
                $tree->disableDeleteButton();
                $row->column(12, $tree);
            });
    }

    // 树形表格-会被index覆盖
    public function grid()
    {
        return Grid::make(new Category(), function (Grid $grid) {
            $grid->id('ID')->bold()->sortable();
            $grid->column('icon')->display(function ($src) {
                if ($src) {
                    return "<i class='iconfont $src' style='max-width:20px;max-height:20px'/>";
                }
                return '暂无';
            });
            $grid->title->tree(true); // 开启树状表格功能
            $grid->column('order')->orderable();
            $grid->status->switch('', true);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->like('title');
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(CategoryModel::class));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(CategoryModel::class));
                }
            });
        });
    }

    protected function detail($id)
    {
        return Show::make($id, new Category(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('icon')->unescape()->as(function ($src) {
                if ($src) {
                    return "<i class='iconfont $src' style='max-width:20px;max-height:20px'/>";
                }
                return '暂无';
            });
            $show->field('description');
            $show->field('order');
            $show->status()->as(function ($status) {
                return $status ? '开启' : '关闭';
            });
            $show->field('user.name','创建者');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        $parents = CategoryModel::where('parent_id',0)->select('id','title')->get();
        $res = [];
        foreach ($parents as $parent) {
            $res[$parent->id] = $parent->title;
        }
        $res[0] = '无';
        return Form::make(new Category(), function (Form $form)use ($res) {
            $form->display('id');
            $form->select('parent_id')->options($res)->default(0);
            $form->text('title')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:navigation_site_categories,title';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '分类标题不能为空',
                'unique' => '分类标题已存在',
                'min' => '分类标题字节字节最小为1',
                'max' => '分类标题字节最大为32',
            ])->required();
            $form->text('icon');
            $iconfontCssUrl = config('navigation.icon_font_url');
            $aStr = '<a href="http://iconfont.huaguoxue.com/?source=' .$iconfontCssUrl. '" target="_blank">点击跳转图标页，点击并复制图标获取名称并填入（一级分类必填）</a>';
            $form->html($aStr);
            $form->textarea('description')->rules('max:255',[
                'max' => '描述字节最大为255',
            ]);
            $form->switch('status')->default(1);
            $form->number('order')->default(0);
            $form->hidden('user_id');
            $form->hidden('depth')->default(1);
            $form->saving(function (Form $form) {
                $form->user_id = Admin::user()->getKey();
                if (!$form->parent_id) $form->depth = 2;
            });
            $form->saved(function (Form $form) {
                Cache::forget(Category::$categoryWithSiteKey);
                Cache::forget(Category::$categoryAllTree);
            });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function searchFirst(Request $request)
    {
        $q = $request->get('q');
        return CategoryModel::where('title', 'like', "%$q%")->where('parent_id','=', 0)->where('status',1)->select('id', 'title as text')->get();
    }

    public function searchChildren(Request $request)
    {
        $provinceId = $request->get('q');
        if ($provinceId) {
            return CategoryModel::where('parent_id', $provinceId)->where('status',1)->get(['id', DB::raw('title as text')]);
        }
        return CategoryModel::where('parent_id', '!=',0)->where('status',1)->get(['id', DB::raw('title as text')]);
    }
}
