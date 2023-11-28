<footer class="main-footer footer-type-1 text-xs">
    <div id="footer-tools" class="d-flex flex-column">
        <a href="javascript:" id="go-to-up" class="btn rounded-circle go-up m-1" rel="go-top">
            <i class="iconfont icon-to-up"></i>
        </a>
        @if(isset($show_home_float) && $show_home_float == 1)
            <a href="/" class="btn rounded-circle m-1" data-placement="left" title="返回首页" data-toggle="tooltip">
                <i class="iconfont icon-zhuye"></i>
            </a>
        @endif
        @if(!isset($show_add) || $show_add == 1)
        <a href="/navigation/contribute" class="btn rounded-circle m-1" one-link-mark="yes">
            <i class="iconfont icon-jsontijiao"></i>
        </a>
        @endif
        <!-- 右下角搜索  -->
        <a href="javascript:" data-toggle="modal" data-target="#search-modal" class="btn rounded-circle m-1"
           rel="search" one-link-mark="yes">
            <i class="iconfont icon-sousuo"></i>
        </a>
        <!-- 右下角搜索 end -->

        <a href="javascript:" onclick="window.location.href='javascript:switchNightMode()'"
           class="btn rounded-circle switch-dark-mode m-1" id="yejian" data-toggle="tooltip"
           data-placement="left" title="夜间模式">
            <i class="mode-ico iconfont icon-yejian"></i>
        </a>
    </div>
    @if(isset($show_footer_inner) && $show_footer_inner == 1)
    <div class="footer-inner" style="text-align: center;">
        <div class="footer-text">本站内容源自互联网，如有内容侵犯了您的权益，请联系删除相关内容。联系邮箱：<strong>{{$related_email}}</strong></div>
    </div>
    @endif
</footer>

<script>
  //夜间模式
  (function () {
    if (document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") === '') {
      if (new Date().getHours() > 22 || new Date().getHours() < 6) {
        document.body.classList.remove('io-black-mode');
        document.body.classList.add('io-grey-mode');
        document.cookie = "night=1;path=/";
        console.log('夜间模式开启');
      } else {
        document.body.classList.remove('night');
        document.cookie = "night=0;path=/";
        console.log('夜间模式关闭');
      }
    } else {
      var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
      if (night == '0') {
        document.body.classList.remove('night');
      } else if (night == '1') {
        document.body.classList.add('night');
      }
    }
  })();
  //夜间模式切换
  function switchNightMode() {
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if (night == '0') {
      document.body.classList.remove('io-grey-mode');
      document.body.classList.add('io-black-mode');
      document.cookie = "night=1;path=/"
      $(".switch-dark-mode").attr("data-original-title", "日间模式");
      $(".mode-ico").removeClass("icon-yejian");
      $(".mode-ico").addClass("icon-yejianms");
    } else {
      document.body.classList.remove('io-black-mode');
      document.body.classList.add('io-grey-mode');
      document.cookie = "night=0;path=/"
      $(".switch-dark-mode").attr("data-original-title", "夜间模式");
      $(".mode-ico").removeClass("icon-yejianms");
      $(".mode-ico").addClass("icon-yejian");
    }
  }

</script>
