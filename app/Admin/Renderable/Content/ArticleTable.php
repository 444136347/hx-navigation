<?php
namespace App\Admin\Renderable\Content;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Models\Content\Article;

class ArticleTable extends LazyRenderable
{
    public function grid(): Grid
    {
        $id = $this->id;
        return Grid::make(new Article(), function (Grid $grid)use ($id) {
            $grid->rowSelector()->check(function ($row) use ($id) {
                return $row->id === $id;
            });
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
