<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    // 导航管理
    $router->group(['prefix' => 'navigation', 'namespace' => 'Navigation',], function (Router $router) {
        //网站管理
        $router->resource('site', 'SiteController');
        // 分类管理
        $router->group(['prefix' => 'category'], function (Router $router) {
            $router->get('/getParent', 'SiteCategoryController@getParent');
            $router->get('/allSearch', 'SiteCategoryController@searchChildren');
        });
        $router->resource('category', 'SiteCategoryController');
        // 标签管理
        $router->group(['prefix' => 'tag'], function (Router $router) {
            $router->get('/allSearch', 'SiteTagController@search');
        });
        $router->resource('tag', 'SiteTagController');
        // 配置
        $router->resource('config', 'ConfigController');
        // 轮播消息
        $router->resource('message', 'MessageController');
        // 用户建议
        $router->resource('suggest', 'SuggestController');
        // 搜索
        $router->resource('search', 'SearchController');
        // 搜索日志
        $router->get('/searchRecord', 'SearchRecordController@index');
    });

    // 内容管理
    $router->group(['prefix' => 'content', 'namespace' => 'Content',], function (Router $router) {
        // 文章管理
        $router->group(['prefix' => 'article'], function (Router $router) {
            $router->get('/search', 'ArticleController@search');
        });
        $router->resource('article', 'ArticleController');
        // 视频管理
        $router->group(['prefix' => 'video'], function (Router $router) {
            $router->get('/search', 'VideoController@search');
        });
        $router->resource('video', 'VideoController');
        // 图集管理
        $router->group(['prefix' => 'picture'], function (Router $router) {
            $router->get('/search', 'PictureController@search');
        });
        $router->resource('picture', 'PictureController');
    });
});
