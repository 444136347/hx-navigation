<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/ajax/libs/jqueryui/1.12.1/jquery-ui.min-3.03029.1.js')}}' id='jquery-ui-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min-3.0302.js')}}' id='jqueryui-touch-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-includes/js/clipboard.min-5.6.2.js')}}' id='clipboard-js'></script>
<script type='text/javascript' id='popper-js-extra'>
  var theme = {
    "ajaxurl": "http://local.travel.ldb/",
    "order": "asc",
    "formpostion": "top",
    "defaultclass": "io-grey-mode",
    "icopng": ".png",
    "urlformat": "1",
    "customizemax": "10",
    "newWindow": "0",
    "lazyload": "1",
    "minNav": "1",
    "loading": "1",
    "hotWords": "baidu",
    "classColumns": " col-sm-6 col-md-4 col-xl-5a col-xxl-6a ",
  };
</script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/popper.min-3.03029.1.js')}}' id='popper-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/bootstrap.min.js')}}' id='bootstrap-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/theia-sticky-sidebar-3.03029.1.js')}}' id='sidebar-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/lazyload.min-3.03029.1.js')}}' id='lazyload-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/jquery.fancybox.min-3.03029.1.js')}}' id='lightbox-js-js'></script>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/wp-content/themes/onenav/js/app-3.03029.1.js')}}' id='appjs-js'></script>
<script type="text/javascript">
  var navigation = {
    'defaultSearchType': 'group-c',
    'defaultSearchMType': 'group-b',
  };
  $(document).ready(function () {
    setTimeout(function () {
      if ($('a.smooth[href="' + window.location.hash + '"]')[0]) {
        $('a.smooth[href="' + window.location.hash + '"]').click();
      }
      else if (window.location.hash != '') {
        $("html, body").animate({
          scrollTop: $(window.location.hash).offset().top - 90
        }, {
          duration: 500,
          easing: "swing"
        });
      }
    }, 300);
    $(document).on('click', 'a.smooth', function (ev) {
      ev.preventDefault();
      if ($('#sidebar').hasClass('show') && !$(this).hasClass('change-href')) {
        $('#sidebar').modal('toggle');
      }
      if ($(this).attr("href").substr(0, 1) == "#") {
        $("html, body").animate({
          scrollTop: $($(this).attr("href")).offset().top - 90
        }, {
          duration: 500,
          easing: "swing"
        });
      }
      if ($(this).hasClass('go-search-btn')) {
        $('#search-text').focus();
      }
      if (!$(this).hasClass('change-href')) {
        var menu = $("a" + $(this).attr("href"));
        menu.click();
        toTarget(menu.parent().parent(), true, true);
      }
    });
    $(document).on('click', 'a.tab-noajax', function (ev) {
      var url = $(this).data('link');
      if (url)
        $(this).parents('.d-flex.flex-fill.flex-tab').children('.btn-move.tab-move').show().attr('href', url);
      else
        $(this).parents('.d-flex.flex-fill.flex-tab').children('.btn-move.tab-move').hide();
    });

    $("#search-list-menu label").click(function(ev){
      navigation.defaultSearchType = ev.currentTarget.dataset.id
    });

    $(".s-type-list label").click(function(ev){
      navigation.defaultSearchMType = ev.currentTarget.dataset.id
    });

    $("#prompt-dialog").click(function(){
      $('#prompt-dialog').css({display:'none'});
    });
  });
  function jumpSite(v, isBlank = 0) {
    console.log(v)
    if (v.hasOwnProperty('show_outside') && v.show_outside === 1 && is_wx()) {
      $('#prompt-dialog').css({display: 'block'});
      stat(v.id)
    } else {
      var urlStr;
      if (parseInt(v.content_type) > 0) {
        urlStr = '/navigation/detail?id=' + v.id
      } else {
        urlStr = v.url
      }
      if (isBlank === 1) {
        window.open(urlStr, '_blank');
        stat(v.id)
      } else {
        window.location.href = urlStr
      }
    }
  }
  function stat (id) {
    var form = new FormData();
    form.append("id", id);
    $.ajax({
      type: 'post',
      url: '/navigation/stat',
      data: form,
      processData: false,
      contentType : false,
      success: function(){
        console.log('统计成功')
      },
      error: function(error){
        console.error(error.responseJSON.message || '统计错误')
      }
    });
  }
  function is_wx(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == "micromessenger") {
      return true;
    } else {
      return false;
    }
  }
</script>
<!-- 自定义代码 -->

<!--五颜六色特效-->
<canvas class="fireworks" style="position:fixed;left:0;top:0;z-index:99999999;pointer-events:none;"></canvas>
<script type='text/javascript' src='{{ admin_asset('vendor/web-stack/cur/aixintexiao.js')}}'></script>
