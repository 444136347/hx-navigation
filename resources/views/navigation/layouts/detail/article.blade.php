<div class="detail-main-info">
    <div class="alert alert-info" role="alert">
        <p><span>介绍：{{$site->description}}</span></p>
    </div>
</div>
<div class="panel panel-tougao card">
    <div class="card-body">
        {!! $site->content->content->content !!}
    </div>
</div>

<style>
    .card-body img {
        max-width:100%;
        max-height:100%
    }
    .detail-main-info {
        padding-top: 1em;
        padding-bottom: 1em;
        font-size: 13px;
    }
    .alert {
        margin-bottom: 0!important;
        color:#000;
    }
</style>
