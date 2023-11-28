<div id="content" class="content-site customize-site">
    @if(count($cws) > 0 && $siteCount)
        @foreach ($cws as $cw)
            @if (isset($cw->site_num) && $cw->site_num > 0)
                @foreach ($cw->children as $c)
                    @if (isset($c->site) && count($c->site) > 0)
                        <div class="d-flex flex-fill">
                            <h4 class="text-gray text-lg mb-4">
                                <i class="site-tag iconfont {{($c->icon ? $c->icon : ($cw->icon ? $cw->icon :  'icon-tag'))}} icon-lg mr-1" id="term-{{$c->id}}"></i>
                                {{$cw->title}}<span style="color:#f1404b"> · </span>{{$c->title}}
                            </h4>
                            <div class="flex-fill"></div>
                        </div>
                        <div class="row">
                            @foreach ($c->site as $s)
                                <div class="url-card col-6  col-sm-6 col-md-4 col-xl-5a col-xxl-6a">
                                    <div class="url-body default">
                                        <a data-target="_blank" class="card no-c mb-4" data-toggle="tooltip"
                                           onClick="jumpSite({{$s}},1)"
                                           data-placement="bottom" title="{{$s->description}}">
                                            <div class="card-body">
                                                <div class="float-right card-body-badge">
                                                    <span class="badge badge-warning">{{\App\Admin\Repositories\Navigation\Site::$contentTypeArr[$s->content_type]}}</span>
                                                </div>
                                                <div class="url-content d-flex align-items-center">
                                                    <div class="url-img rounded-circle mr-2 d-flex align-items-center justify-content-center">
                                                        <img class="lazy" src="{{getFullPath($s->cover_at)}}" data-src="{{getFullPath($s->cover_at)}}"
                                                             onerror="javascript:this.src='{{getFullPath($s->cover_at)}}'" alt="{{$s->title}}">
                                                    </div>
                                                    <div class="url-info flex-fill">
                                                        <div class="text-sm overflowClip_1">
                                                            <strong>{{$s->title}}</strong>
                                                        </div>
                                                        <p class="overflowClip_1 m-0 text-muted text-xs">
                                                            {{$s->description}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="togo text-center text-muted is-views" data-toggle="tooltip" data-placement="right" title="直达" rel="nofollow"
                                           onClick="jumpSite({{$s}})">
                                            <i class="iconfont icon-goto iconfont-goto-font"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    @else
        <div class="d-flex flex-fill">
            <div class="empty-div">
                <img class="img-fluid" src="{{admin_asset('vendor/web-stack/img/empty.png')}}">
            </div>
        </div>
    @endif
</div>
<style>
    .empty-div {
        margin-top:43% !important;
    }
    .img-fluid {
        width:160px;
    }
</style>
<script>$(function(){
    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });
  });</script>
