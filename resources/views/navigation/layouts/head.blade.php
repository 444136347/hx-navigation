<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $config_title }}</title>
    <meta name="theme-color" content="{{ $config_theme_color }}">
    <meta name="keywords" content="{{ $config_keywords }}">
    <meta name="description" content="{{ $config_description }}">
    <meta name="baidu-site-verification" content="{{ $baidu_site_verification }}" />
    <meta property="og:type" content="{{ $config_og_type }}">
    <meta property="og:url" content="{{ $config_og_url }}">
    <meta property="og:title" content="{{ $config_og_title }}">
    <meta property="og:description" content="{{ $config_og_description }}">
    <meta property="og:image" content="{{ $config_og_image }}">
    <meta property="og:site_name" content="{{ $config_og_site_name }}">
    <link rel="stylesheet" href="{{ admin_asset('vendor/web-stack/css/font-awesome.min.css')}}">
    <link rel='stylesheet' href='{{ admin_asset('vendor/slider-captcha-pr/slidercaptcha.css')}}' type='text/css'>

    <link rel='stylesheet' id='iconfontd-css' href='https://at.alicdn.com/t/font_2768144_khli9xs79g.css' type='text/css' media='all'>
    <link rel="icon" href="{{ $config_logo_ico }}">
    @isset($icon_font_url)
        <link rel='stylesheet' id="navigation-iconfont-css" href='{{$icon_font_url}}' type='text/css' media='all'>
    @endisset
    @isset($icon_font_color_url)
        <link rel='stylesheet' id="navigation-color-iconfont-css" href='{{$icon_font_color_url}}' type='text/css' media='all'>
    @endisset
    <link rel='stylesheet' id='wp-block-library-css' href="{{ admin_asset('vendor/web-stack/wp-includes/css/dist/block-library/style.min-5.6.2.css')}}" type='text/css' media='all'>
    <link rel='stylesheet' id='bootstrap-css' href='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/css/bootstrap.min.css')}}' type='text/css' media='all'>
    <link rel='stylesheet' id='lightbox-css' href='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/css/jquery.fancybox.min-3.03029.1.css')}}' type='text/css' media='all'>
    <link rel='stylesheet' id='style-css' href='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/css/style-3.03029.1.css')}}' type='text/css' media='all'>
    <script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/jquery.min-3.03029.1.js')}}' id='jquery-js'></script>

    <!-- 百度统计 -->
    <script>
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?857a179e5c3c11dcb5f3020264295275";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();
    </script>
    <!-- end 百度统计 -->
</head>
