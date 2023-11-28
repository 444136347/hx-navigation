<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Admin;

class AdminController extends \Dcat\Admin\Http\Controllers\AdminController
{
    public function __construct()
    {
        // 加载阿里云iconfont在线css
//        Admin::css('https://at.alicdn.com/t/c/font_4093186_fq5w0ecx3fo.css');
    }
}
