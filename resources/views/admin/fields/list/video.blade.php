<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$model->id}}">
    ▷
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">视频预览</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <video poster="{{isset($model->cover_at) ? $model->getCoverAt() : ''}}" width="320" height="240" controls="controls">
                        <source src="{{$model->getVideoAt()}}" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
