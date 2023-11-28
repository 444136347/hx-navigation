<?php

namespace App\Http\Controllers\Common\Navigation;

use App\Admin\Repositories\Navigation\Category as CategoryRepository;
use App\Admin\Repositories\Navigation\Config as ConfigRepository;
use App\Admin\Repositories\Navigation\Suggest;
use App\Admin\Repositories\Navigation\Tag as TagRepository;
use App\Admin\Repositories\Navigation\Search as SearchRepository;
use App\Admin\Repositories\Navigation\Message as MessageRepository;
use App\Models\Navigation\Search;
use App\Models\Navigation\Site;
use App\Models\Navigation\SiteTag;
use App\Models\Navigation\Tag;
use Fuse\Fuse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Visits\Page;
use App\Admin\Repositories\Navigation\Site as SiteRepositories;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        if (Page::find(1)) {
            visits(Page::find(1))->increment();
        }
        $categoryWithSite = CategoryRepository::getCategoryWithSite();
        $message = MessageRepository::getAll();
        $config = ConfigRepository::getConfigIndexValue();
        $tags = TagRepository::getLimitTen();
        $searches = SearchRepository::getLimitTen();
        return view('navigation.index', array_merge([
            'siteCount' => Site::where('status',1)->count(),
            'tags' => $tags,
            'searches' => $searches,
            'cws' => $categoryWithSite,
            'messages' => $message,
            'show_footer_inner' => 1,
        ],$config));
    }

    public function contribute(Request $request)
    {
        $tags = TagRepository::getLimitTen();
        $config = ConfigRepository::getConfigIndexValue();
        $categoryTree = CategoryRepository::getCategoryAllTree();
        $searches = SearchRepository::getLimitTen();

        return view('navigation.contribute', array_merge([
            'categories' => json_decode(json_encode($categoryTree)),
            'tags' => $tags,
            'searches' => $searches,
            'show_add' => 0,
            'show_home_float' => 1,
        ],$config));
    }

    public function tag(Request $request)
    {
        $tagId = $request->input('id');
        if (!$tagId) {
            return view('navigation.error',['message' => '标签不存在']);
        }
        $siteIds = SiteTag::where('tag_id',$tagId)->pluck('site_id');
        if (!$siteIds) {
            return view('navigation.error',['message' => '标签不存在']);
        }

        $sites = Site::with([
            'category' => function($q) {
                $q->with(['parent'=> function($qp){ $qp->select(['id','title']); }])->select(['id','parent_id','title']);
            },
        ])->whereIn('id',$siteIds)
            ->where('status',1)
            ->orderBy('order','desc')
            ->get();

        $config = ConfigRepository::getConfigIndexValue();
        $tags = TagRepository::getLimitTen();
        $searches = SearchRepository::getLimitTen();
        $sites = SiteRepositories::withContent($sites);
        return view('navigation.tag', array_merge([
            'tag'               => Tag::find($tagId),
            'show_home_float'   => 1,
            'sites'             => $sites,
            'tags'              => $tags,
            'searches'          => $searches,
        ],$config));
    }


    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        if (!$keywords) {
            return view('navigation.error',['message' => '关键字不能为空']);
        }
        SearchRepository::createSearches($keywords, $request->ip());
        $list = Site::with([
            'category' => function($q) {
                $q->with(['parent'=> function($qp){ $qp->select(['id','title']); }])->select(['id','parent_id','title']);
            },
            'tags' => function($q) {
                $q->where('status',1);
            },
        ])->where('status',1)->get()->toArray();
        $list = TagRepository::getTagString($list);
        $options = [ 'keys' => [ 'title', 'description','tagString'],'minMatchCharLength'=>2,'fieldNormWeight'=>1.5];
        $fuse = new Fuse($list, $options);

        $res = $fuse->search($keywords);
        $config = ConfigRepository::getConfigIndexValue();
        $tags = TagRepository::getLimitTen();
        $searches = SearchRepository::getLimitTen();

        return view('navigation.search', array_merge([
            'keyword'           => $keywords,
            'search'            => Search::where('keyword',$keywords)->first(),
            'searches'          => $searches,
            'show_home_float'   => 1,
            'sites'             => json_decode(json_encode($res)),
            'tags'              => $tags,
        ],$config));
    }

    public function detail(Request $request)
    {
        $siteId = $request->input('id');
        if (!$siteId) {
            return view('navigation.error',['message' => '内容不存在']);
        }
        $site = Site::with([
            'category' => function($q) {
                $q->with(['parent'=> function($qp){ $qp->select(['id','title']); }])->select(['id','parent_id','title']);
            },
            'tags',
        ])->where('id',$siteId)->first();
        if (!$site || !$site->status) {
            return view('navigation.error',['message' => '网站不存在']);
        }

        visits($site)->increment();
        $config = ConfigRepository::getConfigIndexValue();
        $tags = TagRepository::getLimitTen();
        $searches = SearchRepository::getLimitTen();
        $site = SiteRepositories::withContent($site,1);
        return view('navigation.detail', array_merge([
            'show_home_float'   => 1,
            'site'              => $site,
            'tops'              => SiteRepositories::getTops($site),
            'tags'              => $tags,
            'searches'          => $searches,
        ],$config));
    }

    public function stat(Request $request)
    {
        $siteId = $request->input('id');
        visits(Site::find($siteId))->increment();
    }

    public function getStat()
    {
        // 另外一种写法，通过Redis模糊获取：Redis::connection('laravel-visits')->command('keys', ['visits:sites_*_total']);
        return visits('App\Models\Navigation\Site','0')->count();
    }

    public function handSuggest(Request $request)
    {
        try {
            $res = Suggest::createFormData($request->all(), $request->ip());
            if (isset($res['status']) && $res['status']) {
                return response(['message' => $res['message'] ?? '投稿成功'], 200);
            }
            return response(['message' => $res['message'] ?? '投稿失败'], 400);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage() ?? '投稿异常'], 400);
        }
    }
}
