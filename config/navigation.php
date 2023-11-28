<?php

return [
    'disk' => 'admin', // 文件上传盘。admin-本地、qiniu-七牛云
    'content_video_limit_size' => 200, // 网站中上传的视频大小限制。单位为M
    'content_image_limit_size' => 10, // 网站中上传的图片大小限制。单位为M
    'content_picture_max_num'  => 9, // 图集最大上传图片数
    'config_title' => '慧信导航-港真的导航网站', // 用户端的网页标题
    'config_theme_color' => '#f9f9f9', // 用户端的主题色
    'config_keywords' => 'AI导航,网址导航,资源导航,设计素材导航,免费软件导航', // 用户端的网页关键字
    'config_description' => '慧信导航 - 精选每个链接', // 用户端的网页描述
    'baidu_site_verification' => 'codeva-uHmMZ13nIE', // 百度网站收录验证码
    'config_og_type' => 'website', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_og_url' => 'https://navigation.huaguoxue.com', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_og_title' => '慧信导航-港真的导航网站', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_og_description' => '慧信导航 - 不求最全，但求好用', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_og_image' => '/vendor/web-stack/logo.png', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_og_site_name' => '慧信导航', // og标签，请参考https://www.yuque.com/u39104802/xbg3ty/xaq1dolda64l7rqi
    'config_logo_ico' => '/vendor/web-stack/logo.ico', // 网站logo的ico格式图
    'config_logo_png' => '/vendor/web-stack/logo.png',// 网站logo的PNG格式图
    'related_email' => '444136347@qq.com', // 网站联系邮箱
    // 用户端首页头部渐变色三色背景，目前使用了三种颜色，理论上无限个
    'header_background_color' => [
        'new1' => [
            'key'   => 'color1',
            'value' => '#5EC277',
        ],
        'new2' => [
            'key'   => 'color3',
            'value' => '#007532',
        ],
        'new3' => [
            'key'   => 'color2',
            'value' => '#81A3FF',
        ],
    ],
];
