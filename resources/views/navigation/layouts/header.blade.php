@include('navigation.layouts.header.bar')
<div class="header-big  post-top css-color mb-4">
    <div class="s-search">
        <div id="search" class="s-search mx-auto">
            <div id="search-list-menu" class="hide-type-list">
                <div class="s-type text-center">
                    <div class="s-type-list big">
                        <div class="anchor" style="position: absolute; left: 50%; opacity: 0;"></div>
                        <label for="type-self" class="active" data-id="group-c"><span>站内搜索</span></label>
                        <label for="type-baidu" data-id="group-b"><span>国内搜索</span></label>
                        <label for="type-soft" data-id="group-a"><span>站外搜索</span></label>
                    </div>
                </div>
            </div>
            <form method="get" class="super-search-fm">
                <input type="text" id="search-text" class="form-control smart-tips search-key">
                <button type="submit" id="search-button"><i class="iconfont icon-search"></i></button>
            </form>
            <div class="card search-smart-tips" style="display: none">
                <ul></ul>
            </div>
            <div id="search-list" class="hide-type-list">
                <div class="search-group group-a">
                    <ul class="search-type">
                        <li><input hidden="" type="radio" name="type" id="type-soft"
                                   value="https://www.423down.com/?s=" data-placeholder="软件搜索"><label
                                    for="type-soft"><span class="text-muted">软件</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-taobao"
                                   value="https://s.taobao.com/search?q=" data-placeholder="淘宝"><label
                                    for="type-taobao"><span class="text-muted">淘宝</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-bing"
                                   value="https://www.douyin.com/search/" data-placeholder="抖音"><label
                                    for="type-bing"><span class="text-muted">抖音</span></label></li>
                    </ul>
                </div>
                <div class="search-group group-b">
                    <ul class="search-type">
                        <li><input hidden="" type="radio" name="type" id="type-baidu"
                                   value="https://www.baidu.com/s?wd=" data-placeholder="百度一下"><label
                                    for="type-baidu"><span class="text-muted">百度</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-360"
                                   value="https://www.so.com/s?q=" data-placeholder="360好搜"><label
                                    for="type-360"><span class="text-muted">360</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-sogo"
                                   value="https://www.sogou.com/web?query=" data-placeholder="搜狗搜索"><label
                                    for="type-sogo"><span class="text-muted">搜狗</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-bing1"
                                   value="https://cn.bing.com/search?q=" data-placeholder="必应搜索"><label
                                    for="type-bing1"><span class="text-muted">必应</span></label></li>
                        <li><input hidden="" type="radio" name="type" id="type-sm"
                                   value="https://yz.m.sm.cn/s?q=" data-placeholder="神马搜索"><label
                                    for="type-sm"><span class="text-muted">神马</span></label></li>
                    </ul>
                </div>
                <div class="search-group group-c">
                    <ul class="search-type">
                        <li>
                            <input checked="checked" hidden="" value="/navigation/search?keywords=" type="radio" name="type" id="type-self" data-placeholder="模糊搜索">
                            <label for="type-self"><span class="text-muted">模糊搜索</span></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if(count($messages) > 0)
    <div class="bulletin-big mx-3 mx-md-0">
        <div id="bulletin_box" class="card my-2">
            <div class="card-body py-1 px-2 px-md-3 d-flex flex-fill text-xs text-muted">
                <div><i class="iconfont icon-laba font-size:26px" style="line-height:25px"></i></div>
                <div class="bulletin mx-1 mx-md-2 carousel-vertical">
                    <div class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner" role="listbox">
                            @foreach ($messages as $mk => $message)
                                @if ($mk == 0)
                                    <div class="carousel-item active">
                                        <a class="overflowClip_1" href="{{$message->link}}" target="_blank">{{$message->text}}</a>
                                    </div>
                                @else
                                    <div class="carousel-item">
                                        <a class="overflowClip_1" href="{{$message->link}}" target="_blank">{{$message->text}}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex-fill"></div>
                <a title="关闭" href="javascript:;" rel="external nofollow" class="bulletin-close"
                   onclick="$('#bulletin_box').slideUp('slow');">
                    <i class="iconfont icon-searchclose" style="line-height:25px"></i>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    var str = 'linear-gradient(45deg,'
    @foreach($header_background_color as $key => $hc)
      @if(isset($hc['value']))
      str += '{{$hc['value']}},'
      @else
        str += '{{$hc->value}},'
      @endif
    @endforeach
    str = str.slice(0, -1) + ')';
    $('.header-big').css('background-image',str)
</script>
