<?php

namespace App\Admin\Repositories\Navigation;

use App\Models\Navigation\Config as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Config extends EloquentRepository
{
    protected $eloquentClass = Model::class;

    public static $cvCacheKey = 'config_all_value_db_res';

    public static $valueList = [
        0 => '简单文本框',
        1 => 'json值',
        2 => '颜色选择',
        3 => '编辑器',
        4 => '图片上传',
    ];

    // 给用户端页面的值
    public static $configMustKeys = [
        'config_title',
        'config_theme_color',
        'config_keywords',
        'config_description',
        'baidu_site_verification',
        'config_og_type',
        'config_og_url',
        'config_og_title',
        'config_og_description',
        'config_og_image',
        'config_og_site_name',
        'config_logo_ico',
        'config_logo_png',
        'header_background_color',
        'icon_font_url',
        'icon_font_color_url',
        'related_email'
    ];

    // 获取用户端需要的变量
    public static function getConfigIndexValue()
    {
        $res = [];
        $all = self::getConfigAllValue();
        foreach (self::$configMustKeys as $key) {
            if (isset($all[$key])) {
                $res[$key] = $all[$key];
            }
        }
        return json_decode(json_encode($res),true);
    }

    // 获取所有的变量数据，会合并变量设置和config/navigation.conf的配置数据
    // 有相同key的情况下，变量设置会覆盖navigation.conf的
    public static function getConfigAllValue($getText = 1)
    {
        if (!Cache::has(self::$cvCacheKey)) {
            $res = self::getDBConfigAllArr();

            if ($getText) $res = array_merge(config('navigation'),$res);
            // 保存24小时
            Cache::put(self::$cvCacheKey, $res, 24 * 60 * 60); // 24小时
        } else {
            $res = Cache::get(self::$cvCacheKey);
        }
        return $res;
    }

    public static function getDBConfigAllArr()
    {
        $res = [];
        $configs = Model::where('status' , 1)->select('key','type','string_value','text_value')->get();
        if (empty($configs)) {
            return $res;
        }
        foreach ($configs as $config) {
            if (self::isString($config->type)) {
                $res[$config->key] = $config->string_value;
            } else {
                $res[$config->key] = json_decode($config->text_value);
            }
        }
        return $res;
    }

    public static function getTypeText($type)
    {
        if (isset(self::$valueList[$type])) {
            return self::$valueList[$type];
        }
        return '未知';
    }

    public static function getColumnName($type)
    {
        $name = '';
        switch ($type) {
            case 0;
                $name = 'value0';
                break;
            case 1;
                $name = 'value1';
                break;
            case 2;
                $name = 'value2';
                break;
            case 3;
                $name = 'value3';
                break;
            case 4;
                $name = 'value4';
                break;
        }
        return $name;
    }

    public static function isString($type)
    {
        if (in_array($type,[0,4])) {
            return true;
        }
        return false;
    }

    public static function load()
    {
        if (Schema::hasTable('navigation_configs')) {
            foreach (self::getConfigAllValue() as $key => $configValue) {
                config(['navigation.'.$key => $configValue]);
            }
        }
    }
}
