<div id="content" class="container my-4 my-md-5">
    <div class="panel card">
        <div class="card-body">
            <h1 class="h2 mb-4">网站提交</h1>
            <div class="panel-body my-2">
                <div class="row">
                    <div class="col-sm-12">
                        <h5><span style="color: #ff0000;">我们欢迎游客提交有趣的网站（请先搜索确认是否重复），我们会尽快对其研究采纳后加入导航，届时请搜索查看是否被采纳，感谢您的参与！</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tougao-form" class="tougao-form">
        <h1 id="comments-list-title" class="comments-title h5 mx-1 my-4">
            <i class="iconfont icon-tougao mr-2"></i>投稿表单
        </h1>
        <div class="panel panel-tougao card">
            <div class="card-body">
                <div class='slider_menu' slidertab="sliderTab">
                    <ul class="nav nav-pills menu" role="tablist">
                        <li class="pagenumber nav-item">
                            <a class="nav-link active" data-toggle="pill" data-type="sites" href="#sites" onclick="currentType(this)">网站</a>
                        </li>
                        <li class="pagenumber nav-item">
                            <a class="nav-link" data-toggle="pill" data-type="down" href="#down" onclick="currentType(this)">资源</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-4">
                    <div id="sites" class="tab-pane active">
                        <form class="i-tougao" method="post" data-type="sites">
                            <input type="hidden" class="form-control" value="sites" name="tougao_type">
                            <div class="row row-sm">
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-name icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_title" placeholder="网站名称 *" maxlength="30">
                                    </div>

                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_sites_link" placeholder="网站链接 *">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-category icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <select name='tougao_cat' id='tougaocategorg_sites' class='form-control'>
                                            @if(count($categories)>0)
                                            <option value='' selected='selected'>选择分类 *</option>
                                            @foreach($categories as $category)
                                                    @if(isset($category->children) && count($category->children)>0)
                                                    @foreach($category->children as $c)
                                                    <option class="level-1" value="{{$c->id}}">{{$category->title}} - {{$c->title}}</option>
                                                    @endforeach
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value='0' selected='selected'>暂无分类 *</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-guanjianzi icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control sites_keywords" value="" name="tougao_keywords" placeholder="网站关键字，请用英语逗号分隔" maxlength="100">
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <label style="vertical-align:top" for="tougao_description">网站介绍:</label>
                                    <textarea class="form-control text-sm" rows="6" cols="55" name="tougao_description" placeholder="请填写些介绍吧"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="down" class="tab-pane fade">
                        <form class="i-tougao" method="post" data-type="down">
                            <input type="hidden" class="form-control" value="down" name="tougao_type">
                            <div class="row row-sm">
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-name icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" id="tougao_title" name="tougao_title" placeholder="资源名称 *" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-version icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_down_version" placeholder="资源版本" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_sites_link" placeholder="官网链接" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_down_preview" placeholder="演示链接" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-url icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_sites_down" placeholder="网盘链接" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-mima icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_sites_password" placeholder="网盘密码" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-mima icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="" name="tougao_down_decompression" placeholder="解压密码" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-6 my-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="iconfont icon-category icon-fw" aria-hidden="true"></i></span>
                                        </div>
                                        <select name='tougao_cat' id='tougaocategorg_down' class='form-control'>
                                            @if(count($categories)>0)
                                                <option value='' selected='selected'>选择分类 *</option>
                                                @foreach($categories as $category)
                                                    @if(isset($category->children) && count($category->children)>0)
                                                        @foreach($category->children as $c)
                                                            <option class="level-1" value="{{$c->id}}">{{$category->title}} - {{$c->title}}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value='0' selected='selected'>暂无分类 *</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <label style="vertical-align:top" for="tougao_description">资源介绍(使用说明):</label>
                                    <textarea class="form-control text-sm" rows="6" cols="55" name="tougao_description" placeholder="请填写些介绍吧"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row row-sm mb-4">
                        <div class="col-12 col-md-3 my-2">
                            <button class="btn btn-danger custom_btn-d text-sm col-12 custom-submit" id="ctModalButton">
                                提交
                            </button>

                            <!-- alertModal -->
                            <div class="modal fade" id="ctModal" tabindex="-1" role="dialog" aria-labelledby="ctModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ctModalLabel">温馨提示</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="ctModalBody">
                                            感谢您的热心提交
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="close-alert" class="btn btn-danger">关闭</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="verifyModalLabel">验证后提交</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="verifyModalModalBody">
                                            <div class="card-body">
                                                <div id="captcha"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="reset-verify-dialog" class="btn btn-info">重置</button>
                                            <button type="button" id="close-verify-dialog" class="btn btn-danger">关闭</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' src='{{ admin_asset('vendor/slider-captcha-pr/slidercaptcha.js')}}'></script>

<script>
  var captcha = sliderCaptcha({
    id: 'captcha',
    width: 280,
    height: 160,
    sliderL: 42,
    sliderR: 9,
    offset: 8,
    loadingText: '正在加载中...',
    failedText: '再试一次',
    barText: '向右滑动填充拼图',
    repeatIcon: 'fa fa-redo',
    setSrc: function () {
        // 设置图片路径
    },
    onSuccess: function () {
      handSuggest()
    },
    onFail: function () {
      // showAlert({label: '错误提示', message:"验证错误，请重试或者联系管理员！"});
    }
  });
  var current_type = 'sites';
  function currentType(file) {
    current_type = $(file).data('type');
  };
  $('.custom-submit').click(function() {
    $('#verifyModal').modal('show');
  });

  function showAlert(json)
  {
    $('#ctModalLabel').text(json.label ?  json.label : '温馨提示')
    $('#ctModalBody').text(json.message ? json.message : '未知错误')
    $('#ctModal').modal('show')
  }

  $('#close-alert').click(function() {
    $('#ctModal').modal('hide')
  });

  $('#close-verify-dialog').click(function() {
    $('#verifyModal').modal('hide')
  });
  $('#reset-verify-dialog').click(function() {
    captcha.reset()
  });

  $('.i-tougao').submit(function() {
    captcha.reset()
    $('#verifyModal').modal('show')
  });

  function handSuggest()
  {
    // 关键字格式检查
    if(checkText($('.i-tougao').find('.sites_keywords').val())){
      return false;
    }
    var myform
    if (current_type === 'down') {
      myform = $('.i-tougao')[1];
    } else {
      myform = $('.i-tougao')[0];
    }
    var formData = new FormData(myform);
    formData.append('action','contribute_post');
    $.ajax({
      url:         '/navigation/contribute/hand',
      type:        'POST',
      dataType:    'json',
      data:        formData,
      cache:       false,
      processData: false,
      contentType: false
    }).done(function (result) {
      $('#verifyModal').modal('hide')
      showAlert(result);
    }).fail(function (result) {
      $('#verifyModal').modal('hide')
      showAlert({label: "错误提示", message: result.responseJSON && result.responseJSON.hasOwnProperty('message') ?  result.responseJSON.message : '网络错误' });
    });
    captcha.reset()
  }

  function checkText(text)
  {
    if (text) {
      var reg = /[\u3002|\uff1f|\uff01|\uff0c|\u3001|\uff1b|\uff1a|\u201c|\u201d|\u2018|\u2019|\uff08|\uff09|\u300a|\u300b|\u3008|\u3009|\u3010|\u3011|\u300e|\u300f|\u300c|\u300d|\ufe43|\ufe44|\u3014|\u3015|\u2026|\u2014|\uff5e|\ufe4f|\uffe5]/;
      if (reg.test(text)) {
        showAlert(JSON.parse('{"label":"错误提示","message":"关键词请使用英语逗号分隔。"}'));
        return true;
      } else {
        return false;
      }
    }
    return false
  };
</script>
