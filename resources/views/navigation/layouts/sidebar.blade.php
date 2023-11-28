<div id="sidebar" class="sticky sidebar-nav fade mini-sidebar" style="width: 60px;">
    <div class="modal-dialog h-100  sidebar-nav-inner">
        <div class="sidebar-logo border-bottom border-color">
            <!-- logo -->
            <div class="logo overflow-hidden">
                <a href="" class="logo-expanded">
                    <img src="{{$config_logo_png}}" height="40" class="logo-light"
                         alt="{{$config_title}}">
                    <img src="{{$config_logo_png}}" height="40" class="logo-dark d-none"
                         alt="{{$config_title}}">
                </a>
                <a href="" class="logo-collapsed">
                    <img src="{{$config_logo_png}}" height="40" class="logo-light"
                         alt="{{$config_title}}">
                    <img src="{{$config_logo_png}}" height="40" class="logo-dark d-none"
                         alt="{{$config_title}}">
                </a>
            </div>
            <!-- logo end -->
        </div>
        <div class="sidebar-menu flex-fill">
            <div class="sidebar-scroll">
                <div class="sidebar-menu-inner">
                    <ul>
                        <li class="sidebar-item top-menu">
                            <a href="javascript:;" class="smooth change-href">
                                <i class="iconfont icon-zhuye icon-fw icon-lg mr-2"></i>
                                <span>{{$config_og_site_name}}</span>
                                <i class="iconfont icon-arrow-r-m sidebar-more text-sm"></i>
                            </a>
                            <ul>
                                <li id="menu-item-281"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-281">
                                    <a href="/">
                                        <i class="fa fa-home fa-lg mr-2"></i>
                                        <span>首页</span></a>
                                </li>
                            </ul>
                        </li>
                        @foreach ($cws as $cw)
                            @if (isset($cw->site_num) && $cw->site_num > 0)
                                <li class="sidebar-item">
                                    <a href="javascript:;" class="smooth change-href" data-change="#term-{{$cw->children[0]->id}}}">
                                        <i class="iconfont {{$cw->icon}} icon-fw icon-lg mr-2"></i>
                                        <span>{{$cw->title}}</span>
                                        <i class="iconfont icon-arrow-r-m sidebar-more text-sm"></i>
                                    </a>
                                    <ul>
                                        @foreach ($cw->children as $c)
                                            @if (isset($c->site) && count($c->site) > 0)
                                                <li>
                                                    <a href="#term-{{$c->id}}" class="smooth"><span>{{$c->title}}</span></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
