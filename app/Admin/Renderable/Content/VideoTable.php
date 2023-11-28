<?php
namespace App\Admin\Renderable\Content;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Models\Content\Video;

class VideoTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new Video(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('title');
            $grid->column('sub_title','副标题');
            $grid->column('status')->using([0 => '关闭', 1 => '开启'])->badge([
                0 => 'danger',
                1 => 'success',
            ]);

            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->quickSearch(['id', 'title', 'sub_title']);

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title')->width(4);
                $filter->like('sub_title','副标题')->width(4);
            });
        });
    }
}
