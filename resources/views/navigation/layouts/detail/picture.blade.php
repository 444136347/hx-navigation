<div class="alert alert-info" role="alert">
    <p><span>介绍：{{$site->description}}</span></p>
</div>
<div class="card">
    <ul class="row first picture-ul">
        @foreach($site->content->attachments as $key => $attach)
            <li>
                <img alt="图集"
                     src="{{getFullPath($attach->url)}}">
                <p>{{$attach->desc}}</p>
            </li>
        @endforeach
    </ul>
</div>
<link rel="stylesheet" href="{{ admin_asset('vendor/bootstrap-photo-gallery/jquery.bsPhotoGallery.css')}}">
<script type='text/javascript'
        src='{{ admin_asset('vendor/bootstrap-photo-gallery/jquery.bsPhotoGallery.js')}}'></script>

<script>
  $(document).ready(function () {
    $('ul.first').bsPhotoGallery({
      "classes": "col-xl-4 col-lg-3 col-md-6 col-sm-6",
      "hasModal": true,
      "shortText": false
    });
  });
</script>
<style>
    .card {
        padding-top: 10px;
    }
    .alert {
        font-size: 13px;
    }
</style>
