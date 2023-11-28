<div>
    <div class="alert alert-info alert-info-div" role="alert">
        <h5><span class="alert-info-span">当前导航关键字：</span><span class="badge badge-primary">{{$keyword}}</span></h5>
    </div>
</div>
<div id="content" class="content-site customize-site">
    <div class="row">
        @if(count($sites) > 0)
        @foreach ($sites as $s)
            <div class="url-card col-12  col-sm-12 col-md-12 col-xl-12a col-xxl-12a">
                <div class="url-body default">
                    <a onClick="jumpSite({{json_encode($s->item)}},1)" class="card no-c mb-4" data-toggle="tooltip"
                       data-placement="bottom" title="{{$s->item->description}}">
                        <div class="card-body">
                            <div class="float-right card-body-badge">
                                <span class="badge badge-warning">{{\App\Admin\Repositories\Navigation\Site::$contentTypeArr[$s->item->content_type]}}</span>
                            </div>
                            <div class="url-content d-flex align-items-center">
                                <div class="url-img rounded-circle mr-2 d-flex align-items-center justify-content-center">
                                    <img class="lazy" src="{{getFullPath($s->item->cover_at)}}" data-src="{{getFullPath($s->item->cover_at)}}"
                                         onerror="javascript:this.src='{{getFullPath($s->item->cover_at)}}'" alt="{{$s->item->title}}">
                                </div>
                                <div class="url-info flex-fill">
                                    <div class="text-sm overflowClip_1">
                                        <strong>{{$s->item->title}}</strong>
                                    </div>
                                    <p class="overflowClip_1 m-0 text-muted text-xs">
                                        {{$s->item->description}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a onClick="jumpSite({{json_encode($s->item)}})" class="togo text-center text-muted is-views"
                       data-toggle="tooltip" data-placement="right" title="直达" rel="nofollow"><i
                                class="iconfont icon-goto iconfont-goto-font"></i></a>
                </div>
            </div>
        @endforeach
        @else
            <div class="d-flex flex-fill">
                <div class="empty-div">
                    <img class="img-fluid" src="{{admin_asset('vendor/web-stack/img/empty.png')}}">
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .alert-info-span {
        font-size: 16px;
    }

    .alert-info-div {
        border-radius: 0
    }

    .empty-div {
        margin-top: 60% !important;
    }

    .img-fluid {
        width: 160px;
    }
</style>
