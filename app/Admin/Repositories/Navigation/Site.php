<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Content\Article;
use App\Models\Content\Picture;
use App\Models\Content\Video;
use App\Models\Navigation\Site as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Site extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $contentTypeArr = [
        0 => '跳转',
        1 => '文章',
        2 => '图集',
        3 => '视频'
    ];

    public static function getTops($site)
    {
        return visits(Model::class)->top(2, [['content_type', '=', $site->content_type],['id','!=',$site->id]]);
    }

    public static function getContent($type,$id)
    {
        if ($type && $id) {
            if ($type == 1) {
                return Article::with('content')->find($id);
            } else if ($type == 2) {
                return Picture::with(['attachments'=>function($q) {
                    $q->orderBy('order','asc');
                }])->find($id);
            } else if ($type == 3) {
                return Video::find($id);
            }
        }
        return null;
    }

    // $type = 0为二维数组，1为一维数组
    public static function withContent($data,$type = 0)
    {
        $data = $data->toArray();
        if ($type == 0) {
            foreach ($data as &$d) {
                $d['content'] = self::getContent($d['content_type'],$d['content_id']);
            }
        } else {
            $data['content'] = self::getContent($data['content_type'],$data['content_id']);
        }
        return json_decode(json_encode($data));
    }
}
