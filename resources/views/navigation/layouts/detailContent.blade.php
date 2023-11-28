<header>
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top">
        <a class="navbar-brand d-md-none" href="#" title="{{$config_title}}">
            <img src="{{$config_logo_png}}" class="logo-light" width="40" height="40"
                 alt="{{$config_title}}">
            <img src="{{$config_logo_png}}" class="logo-dark d-none" width="40" height="40"
                 alt="{{$config_title}}">
            @if($site->category)
                <span class="breadcrumb-item-span">{{$site->category->parent->title}}<span
                            style="color: #6c757d"> / </span></span>
                <span class="breadcrumb-item-span">{{$site->category->title}}<span
                            style="color: #6c757d"> / </span></span>
            @endif
            <span class="breadcrumb-item-span active">{{$site->title}}</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <a class="navbar-brand" href="/" title="{{$config_title}}">
                <img src="{{$config_logo_png}}" class="logo-light" width="40" height="40"
                     alt="{{$config_title}}">
                <img src="{{$config_logo_png}}" class="logo-dark d-none" width="40" height="40"
                     alt="{{$config_title}}">
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @if($site->category)
                        <li class="breadcrumb-item">{{$site->category->parent->title}}</li>
                        <li class="breadcrumb-item">{{$site->category->title}}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{$site->title}}</li>
                </ol>
            </nav>
        </div>
    </nav>
</header>
<main class="detail-main">
    <div class="jumbotron">
        <div class="row">
            <div class="col-8">
                <div class="float-left">
                    <h6>{{$site->title}}
                        <small class="text-muted">
                            @if(count($site->tags) > 0 )
                                @foreach($site->tags as $tag)
                                    <a href="/navigation/tag?id={{$tag->id}}"
                                       class="badge badge-warning">{{$tag->name}}</a>
                                @endforeach
                            @endif
                        </small>
                    </h6>
                    <span class="blog-post-meta">{{convertAtTime($site->updated_at)}}</span>
                </div>
            </div>
            <div class="col-4">
                <a href="{{$site->url}}" class="btn btn-warning btn-sm float-right go-web" role="button"
                   aria-pressed="true">
                    <i class="iconfont icon-website text-sm"></i> 前往
                </a>
            </div>
        </div>
    </div>
    <div class="detail">
        @if($site->content_type == 1 )
            @include('navigation.layouts.detail.article')
        @elseif($site->content_type == 2)
            @include('navigation.layouts.detail.picture')
        @elseif($site->content_type == 3)
            @include('navigation.layouts.detail.video')
        @endif
    </div>
    @if(isset($tops) && count($tops) > 0)
        <div class="detail-like">
            <hr/>
            <h6 class="pb-1 mb-9">
                <i class="iconfont icon-fuwu icon-fw" aria-hidden="true"></i> 猜你喜欢
            </h6>
            <div class="row mb-2">
                @foreach($tops as $top)
                    <div class="col-md-6">
                        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                            <div class="col p-2 d-flex flex-column position-static like-div">
                                <h6 class="mb-0">{{$top->title}}</h6>
                                <p class="card-text mb-auto">{{$top->description}}</p>
                                <a href="/navigation/detail?id={{$top->id}}" class="btn-link btn-sm">
                                    <i class="iconfont icon-goto text-sm"></i> 前往
                                </a>
                            </div>
                            <div class="col-auto d-lg-block">
                                <img src="{{isset($top->cover_at) ? getFullPath($top->cover_at) : ''}}" class="ml-3"
                                     style="padding:0.5em" width="160" height="160">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</main>

<style>
    .detail-main {
        padding: 0.5em
    }

    .jumbotron {
        margin-top: 5em;
        margin-bottom: 0 !important;
        border-radius: 0 !important;
        padding: 0 0 1em 0 !important;
        background-color: transparent !important;
    }

    .breadcrumb {
        border-radius: 0 !important;
        margin-bottom: 0 !important;
        background-color: transparent !important;
    }

    .breadcrumb .breadcrumb-item {
        color: #f2f2f2;
    }

    .breadcrumb-item.active {
        color: #ffffff;
    }

    .breadcrumb-item-span {
        font-size: 13px;
        color: #f2f2f2;
    }

    .breadcrumb-item-span.active {
        color: #ffffff;
    }

    .go-web {
        border: 1px solid #dee2e6 !important;
        border-radius: 0.25rem;
    }

    .like-div > p {
        font-size: 13px;
        padding-top: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .blog-post-meta {
        font-size: 13px;
        margin-bottom: 1.25rem;
        color: #999;
    }
</style>
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
  $('.fixed-top').css('background-image', str)
</script>
