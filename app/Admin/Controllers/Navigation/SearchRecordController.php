<?php

namespace App\Admin\Controllers\Navigation;

use App\Admin\Controllers\AdminController;
use App\Admin\Repositories\Navigation\SearchRecord;
use Carbon\Carbon;
use Dcat\Admin\Grid;
use Illuminate\Support\Facades\Request;
use Dcat\Admin\Widgets\Alert;

class SearchRecordController extends AdminController
{
    protected function grid()
    {
        $all = Request::all(['month']);
        $ym = $all['month'] ? Carbon::parse($all['month'])->format('Ym') :Carbon::today()->format('Ym');
        $searchRecord = new SearchRecord($ym);

        return Grid::make($searchRecord, function (Grid $grid)use ($ym) {
            $grid->header(function ($collection) {
                $alert = Alert::make('当前的搜索记录仅展示一个月的数据，如果需要查看以前的数据，请点击筛选，选择查看月份', '温馨提示');
                return $alert->info()->setHtmlAttribute("style","margin:10px 0");
            });
            $grid->title("当前月份：".$ym);
            $grid->column('id', 'ID')->sortable();
            $grid->column('keyword','关键字');
            $grid->column('ip');
            $grid->column('created_at');
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->setActionClass(Grid\Displayers\Actions::class);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->month('month','月份')->default((Carbon::now())->format('Ym'))->ignore();
                $filter->like('keyword','关键字')->placeholder("搜索关键字")->width(4);
            });
        });
    }
}
