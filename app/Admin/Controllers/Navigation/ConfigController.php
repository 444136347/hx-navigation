<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Actions\Restore\BatchRestore;
use App\Admin\Actions\Restore\Restore;
use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Navigation\Config;
use App\Models\Navigation\Config as ConfigModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Cache;

class ConfigController extends AdminController
{
    protected $translation = 'navigation-config';

    protected function grid()
    {
        return Grid::make(new Config(), function (Grid $grid) {
            $grid->model()->with(['user']);

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('type')->display(function ($type) {
                $type = Config::getTypeText($type);
                return "<span style='color:#3F7F5F'>".$type."</span>";
            });
            $grid->column('key');
            // 添加不存在的字段
            $grid->column('value')->display(function () {
                if (Config::isString($this->type)) {
                    return $this->string_value ? "<span style='color:#3F7F5F'>".$this->string_value."</span>" : '暂无';
                }
                return $this->text_value ? "<span style='color:#3F7F5F'>".$this->text_value."</span>" : '暂无';
            });
            $grid->status()->switch('', true);

            $grid->column('user.name', '创建者');

            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('id');
                $filter->like('name');
                $filter->like('key');
                $filter->equal('type')->select(Config::$valueList)->width(4);
                $filter->equal('status')->select([0 => '关闭',1 => '开启'])->width(4);

                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(ConfigModel::class,[Config::$cvCacheKey]));
                }
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(ConfigModel::class,[Config::$cvCacheKey]));
                }
            });
        });
    }

    protected function detail($id)
    {
        $model = Config::with(['user']);
        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('key');

            $show->field('description','描述');
            $show->type()->as(function ($type) {
                // 获取当前行的其他字段
                $name = Config::getTypeText($type);
                return "{$name}";
            });
            $bool = Config::isString($show->model()->type);
            if($bool) {
                $res = $show->field('string_value');
                if ($show->model()->type == 4) {
                    $res->image();
                }
            } else {
                $show->field('text_value');
            }
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
        return Form::make(new Config(), function (Form $form){
            $form->model()->with(['user']);

            $form->display('id');

            $form->text('name')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:32|unique:navigation_configs,name';
                }
                return 'required|min:1|max:32';
            },[
                'required' => '配置名称不能为空',
                'unique' => '配置名称已存在',
                'min' => '配置名称字节最小为1',
                'max' => '配置名称字节最大为32',
            ])->required();
            $form->text('key')->rules(function (Form $form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|min:1|max:255|unique:navigation_configs,key';
                }
                return 'required|min:1|max:255';
            },[
                'required' => '变量key不能为空',
                'unique' => '变量key已存在',
                'min' => '变量key字节最小为1',
                'max' => '变量key字节最大为255',
            ])->required();
            $form->radio('type')
                ->when(0, function (Form $form) {
                    $value = '';
                    if ($form->isEditing() && $form->model()->type == 0) $value = Config::isString($form->model()->type) ? $form->model()->string_value : $form->model()->text_value;
                    $form->text('value0','值')->value($value);
                })
                ->when(1, function (Form $form) {
                    $value = '';
                    if ($form->isEditing() && $form->model()->type == 1) $value = Config::isString($form->model()->type) ? $form->model()->string_value : $form->model()->text_value;
                    $form->table('value1','值', function (NestedForm $table) {
                        $table->text('key');
                        $table->text('value');
                    })->value($value);
                })
                ->when(2, function (Form $form) {
                    $value = '';
                    if ($form->isEditing() && $form->model()->type == 2) $value = Config::isString($form->model()->type) ? $form->model()->string_value : $form->model()->text_value;
                    $form->table('value2','值', function (NestedForm $table) {
                        $table->text('key')->placeholder('颜色值的key，比如color1');
                        $table->color('value')->placeholder('光标输入选择颜色');
                    })->value($value);
                })
                ->when(3, function (Form $form) {
                    $value = '';
                    if ($form->isEditing() && $form->model()->type == 3) $value = Config::isString($form->model()->type) ? $form->model()->string_value : $form->model()->text_value;
                    $form->editor('value3','值')->value($value);
                })
                ->when(4, function (Form $form) {
                    $value = '';
                    if ($form->isEditing() && $form->model()->type == 4) $value = Config::isString($form->model()->type) ? $form->model()->string_value : $form->model()->text_value;
                    $form->image('value4','值')
                        ->autoUpload()
                        ->autoSave(false)
                        ->removable(false)
                        ->accept('jpg,png,gif,jpeg', 'image/*')
                        ->help('目前上传格式支持：jpg,png,gif,jpeg，最大为'.(getCiSize()/1024).'M')
                        ->maxSize(getCiSize())
                        ->disk(getDisk())
                        ->saveFullUrl(whetherSaveFullUrl())
                        ->value($value);
                })
                ->options(Config::$valueList)
                ->default(0);
            $form->textarea('description','描述')->rules('max:255',[
                'max' => '描述字节最大为255',
            ]);
            $form->switch('status')->default(1);

            $form->hidden('user_id');
            $form->hidden('string_value');
            $form->hidden('text_value');
            $form->submitted(function (Form $form) {
                // 获取用户提交参数
                $type = $form->type;
                $column = Config::getColumnName($form->type);
                if (Config::isString($type)) {
                    $form->string_value = $form->$column;
                } else {
                    $form->text_value = json_encode($form->$column);
                }
                if(!$form->string_value && !$form->text_value) {
                    // 中断后续逻辑
                    return $form->response()->error('值不能为空！');
                }
            });
            $form->ignore(['value0','value1','value2','value3','value4',]);
            $form->saving(function (Form $form) {
                $form->user_id = Admin::user()->getKey();
            });
            $form->saved(function (Form $form) {
                Cache::forget(Config::$cvCacheKey);
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
        Cache::forget(Config::$cvCacheKey);
        return $this->form()->destroy($id);
    }
}
