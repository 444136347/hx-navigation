<?php

namespace App\Admin\Repositories\Content;

use App\Models\Content\Video as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use GuzzleHttp\Client as GuzzleHttpClient;
use getID3;

class Video extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static function getVideoSecond($form)
    {
        $seconds = 0;
        if ($form->video_at && getDisk() == 'qiniu') {
            $res = json_decode((new GuzzleHttpClient())->request('GET', $form->video_at . '?avinfo')->getBody()->getContents(), true);
            if (isset($res['format']['duration'])) {
                $seconds = $res['format']['duration'];
            }
        } else if ($form->video_at && getDisk() == 'admin') {
            $getID3 = new getID3();
            $path = ltrim(parse_url(getFullPath($form->video_at),PHP_URL_PATH),'/');
            $fileInfo = $getID3->analyze($path);
            $seconds  = $fileInfo['playtime_seconds'] ?? 0;
        }
        return $seconds;
    }
}
