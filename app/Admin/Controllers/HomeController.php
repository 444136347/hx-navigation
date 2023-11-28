<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Navigation;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('仪表盘')
            ->description('')
            ->body(function (Row $row) {
                $row->column(3, new Navigation\Home());
                $row->column(9, new Navigation\Site());
            });
    }
}
