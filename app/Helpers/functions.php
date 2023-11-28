<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// 二维数组排序
if(!function_exists('multiArraySort')) {
    function multiArraySort($multi_array, $sort_key, $sort = SORT_DESC)
    {
        if (is_array($multi_array)) {
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_array, $sort, $multi_array);
        return $multi_array;
    }
}

// 获取文件上传的disk
if(!function_exists('getDisk')) {
    function getDisk()
    {
        if (config('navigation.disk')) return config('navigation.disk');
        if (config('admin.upload.disk')) return config('admin.upload.disk');
    }
}

// 获取网站上传视频的大小。
if(!function_exists('getCvSize')) {
    // 返回单位为K，但是设置文件单位为M，需要乘以1024
    function getCvSize()
    {
        if (config('navigation.content_video_limit_size')) {
            return 1024 * config('navigation.content_video_limit_size');
        }
        return 1024 * 500; // 默认500M
    }
}

// 获取网站上传图片、封面图的大小。
if(!function_exists('getCiSize')) {
    // 返回单位为K，但是设置文件单位为M，需要乘以1024
    function getCiSize()
    {
        if (config('navigation.content_image_limit_size')) {
            return 1024 * config('navigation.content_image_limit_size');
        }
        return 1024 * 10; // 默认10M
    }
}

// 获取文件全路径
if(!function_exists('getFullPath')) {
    function getFullPath($path)
    {
        if (Str::contains($path, '//')) return $path;
        return Storage::disk(getDisk())->url($path);
    }
}

// 是否支持拼接域名上传
if(!function_exists('whetherSaveFullUrl')) {
    function whetherSaveFullUrl(): bool
    {
        if(getDisk() == 'qiuniu') {
            return true;
        }
        return false;
    }
}

// 时间处理不带T
if(!function_exists('convertAtTime')) {
    function convertAtTime($at): string
    {
        return Carbon\Carbon::parse($at)->format("Y-m-d H:i");
    }
}

