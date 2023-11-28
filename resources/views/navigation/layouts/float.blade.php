<div class="modal fade search-modal" id="search-modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div id="search" class="s-search mx-auto my-4">
                    <div id="search-modal-list" class="hide-type-list">
                        <div class="s-type">
                            <span></span>
                            <div class="s-type-list">
                                <label for="m_type-self" data-id="group-b">站内</label>
                                <label for="m_type-baidu" data-id="group-a">常用</label>
                            </div>
                        </div>
                        <div class="search-group group-b">
                            <span class="type-text text-muted">站内</span>
                            <ul class="search-type">
                                <li>
                                    <input checked="checked" hidden="" type="radio" name="type2" id="m_type-self"
                                           value="/navigation/search?keywords="
                                           data-placeholder="模糊搜索">
                                    <label><span class="text-muted">模糊搜索</span></label>
                                </li>
                            </ul>
                        </div>
                        <div class="search-group group-a">
                            <span class="type-text text-muted">常用</span>
                            <ul class="search-type">
                                <li><input hidden="" type="radio" name="type2" id="m_type-baidu"
                                           value="https://www.baidu.com/s?wd=" data-placeholder="百度一下"><label
                                            for="m_type-baidu"><span class="text-muted">百度</span></label></li>
                                <li><input hidden="" type="radio" name="type2" id="m_type-zhannei"
                                           value="https://www.423down.com/?s=" data-placeholder="软件搜索"><label
                                            for="m_type-zhannei"><span class="text-muted">软件</span></label></li>
                                <li><input hidden="" type="radio" name="type2" id="m_type-bing"
                                           value="https://www.douyin.com/search/" data-placeholder="抖音"><label
                                            for="m_type-bing"><span class="text-muted">抖音</span></label></li>
                            </ul>
                        </div>
                    </div>
                    <form class="super-search-fm">
                        <input type="text" id="m_search-text" class="form-control smart-tips search-key"
                               autocomplete="off" placeholder="输入关键字搜索" style="outline:0">
                        <button type="submit" id="search-button-m"><i class="iconfont icon-search"></i></button>
                    </form>
                    <div class="card search-smart-tips" style="display: none">
                        <ul></ul>
                    </div>
                </div>
                <div>
                    <div class="px-1 mb-3">
                        <i style="font-size: 1.6rem!important" class="text-xl iconfont icon-remenbiaoqian mr-1"></i>
                    </div>
                    <div class="mb-3">
                        @if(isset($tags) && count($tags) > 0)
                            @foreach($tags as $t)
                                @if(isset($tag) && $t->id == $tag->id)
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-post_tag"><a
                                                href="/navigation/tag?id={{$t->id}}" style="color: #e21b24">{{$t->name}}</a>
                                    </li>
                                @else
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-post_tag"><a
                                                href="/navigation/tag?id={{$t->id}}">{{$t->name}}</a></li>
                                @endif
                            @endforeach
                        @else
                            <span class="has-small-font-size">暂无数据</span>
                        @endif
                    </div>
                </div>
                <div style="padding-top: 1em">
                    <div class="px-1 mb-3">
                        <i style="font-size: 1.6rem!important" class="text-xl iconfont icon-remensousuo mr-1"></i>
                    </div>
                    <div class="mb-3">
                        @if(isset($searches) && count($searches) > 0)
                            @foreach($searches as $s)
                                @if(isset($search) && $s->id == $search->id)
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-post_tag"><a
                                                href="/navigation/search?keywords={{$s->keyword}}" style="color: #e21b24">{{$s->keyword}}</a>
                                    </li>
                                @else
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-post_tag"><a
                                                href="/navigation/search?keywords={{$s->keyword}}">{{$s->keyword}}</a></li>
                                @endif
                            @endforeach
                        @else
                            <span class="has-small-font-size">暂无数据</span>
                        @endif
                    </div>
                </div>
                <div style="position: absolute;bottom: -40px;width: 100%;text-align: center;">
                    <a href="javascript:" data-dismiss="modal">
                        <i class="iconfont icon-gary icon-2x" style="color: #fff;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 微信指示遮罩 start -->
@include('navigation/components/prompt')
<!-- 微信指示遮罩 end -->
