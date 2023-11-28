<div>
    <div class="embed-responsive embed-responsive-16by9">
        <video poster="{{isset($site->content->cover_at) ? getFullPath($site->content->cover_at) : ''}}" width="320" height="240" controls="controls">
            <source src="{{getFullPath($site->content->video_at)}}" type="video/mp4">
        </video>
    </div>
    <div class="detail-main-info">
        <div class="alert alert-info" role="alert">
            <p><span>介绍：{{$site->description}}</span></p>
        </div>
    </div>
</div>

<style>
    .embed-responsive {
        border: 1px solid #dee2e6!important;
        border-radius: 0.25rem;
    }
    .detail-main-info {
        padding-top: 1em;
        padding-bottom: 1em;
        font-size: 13px;
    }
</style>
