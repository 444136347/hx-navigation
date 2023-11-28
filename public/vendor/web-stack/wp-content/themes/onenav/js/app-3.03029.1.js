(function($){
    $(document).ready(function(){
        // 侧栏菜单初始状态设置
        if(theme.minNav != '1')trigger_resizable(true);
        intoSearch();
        // 粘性页脚
        stickFooter();
        // 网址块提示
        if(isPC()){ $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'}); }else{ $('.qr-img[data-toggle="tooltip"]').tooltip({trigger: 'hover'}); }
        // 初始化tab滑块
        intoSlider();
        // 初始化theiaStickySidebar
        $('.sidebar').theiaStickySidebar({
            additionalMarginTop: 90,
            additionalMarginBottom: 20
        });
    });
    $(".panel-body.single img").each(function(i) {
        if (!this.parentNode.href) {
            if(theme.lazyload)
                $(this).wrap("<a href='" + $(this).data('src') + "' data-fancybox='fancybox' data-caption='" + this.alt + "'></a>")
            else
                $(this).wrap("<a href='" + this.src + "' data-fancybox='fancybox' data-caption='" + this.alt + "'></a>")
        }
    })
    // Enable/Disable Resizable Event
    var wid = 0;
    $(window).resize(function() {
        clearTimeout(wid);
        wid = setTimeout(go_resize, 200);
    });
    function go_resize() {
        stickFooter();
        trigger_resizable(false);
    }

    //返回顶部
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 50) {
            $('#go-to-up').fadeIn(200);
            $('.big-header-banner').addClass('header-bg');
        } else {
            $('#go-to-up').fadeOut(200);
            $('.big-header-banner').removeClass('header-bg');
        }
    });
    $('.go-up').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
    return false;
    });


    //滑块菜单
    $('.slider_menu').children("ul").children("li").not(".anchor").hover(function() {
        $(this).addClass("hover"),
        toTarget($(this).parent(),true,true)
    }, function() {
        $(this).removeClass("hover")
    });
    $('.slider_menu').mouseleave(function(e) {
        var menu = $(this).children("ul");
        window.setTimeout(function() {
            toTarget(menu,true,true)
        }, 50)
    }) ;
    function intoSlider() {
        $(".slider_menu[sliderTab]").each(function() {
            if(!$(this).hasClass('into')){
                var menu = $(this).children("ul");
                menu.prepend('<li class="anchor" style="position:absolute;width:0;height:28px"></li>');
                var target = menu.find('.active').parent();
                if(0 < target.length){
                    menu.children(".anchor").css({
                        left: target.position().left + target.scrollLeft() + "px",
                        width: target.outerWidth() + "px",
                        height: target.height() + "px",
                        opacity: "1"
                    })
                }
                $(this).addClass('into');
            }
        })
    }
    //粘性页脚
    function stickFooter() {
        $('.main-footer').attr('style', '');
        if($('.main-footer').hasClass('text-xs'))
        {
            var win_height                 = jQuery(window).height(),
                footer_height             = $('.main-footer').outerHeight(true),
                main_content_height         = $('.main-footer').position().top + footer_height ;
            if(win_height > main_content_height - parseInt($('.main-footer').css('marginTop'), 10))
            {
                $('.main-footer').css({
                    marginTop: win_height - main_content_height
                });
            }
        }
    }


    $('#sidebar-switch').on('click',function(){
        $('#sidebar').removeClass('mini-sidebar');
        $('.sidebar-nav .change-href').attr('href','javascript:;');

    });

    // Trigger Resizable Function
    var isMin = false,
        isMobileMin = false;
    function trigger_resizable( isNoAnim ) {
        if( (theme.minNav == '1' && !isMin && 767.98<$(window).width() )||(!isMin && 767.98<$(window).width() && $(window).width()<1024) ){
            $('#mini-button').prop('checked', false);
            trigger_lsm_mini(isNoAnim);
            isMin = true;
            if(isMobileMin){
                $('#sidebar').addClass('mini-sidebar');
                $('.sidebar-nav .change-href').each(function(){$(this).attr('href',$(this).data('change'))});
                isMobileMin = false;
            }
        }
        else if( ( theme.minNav != '1')&&((isMin && $(window).width()>=1024) || ( isMobileMin && !isMin && $(window).width()>=1024 ) ) ){
            $('#mini-button').prop('checked', true);
            trigger_lsm_mini(isNoAnim);
            isMin = false;
            if(isMobileMin){
                isMobileMin = false;
            }
        }
        else if($(window).width() < 767.98 && $('#sidebar').hasClass('mini-sidebar')){
            $('#sidebar').removeClass('mini-sidebar');
            $('.sidebar-nav .change-href').attr('href','javascript:;');
            isMobileMin = true;
            isMin = false;
        }
    }
    // sidebar-menu-inner收缩展开
    $('.sidebar-menu-inner a').on('click',function(){//.sidebar-menu-inner a //.has-sub a
        if (!$('.sidebar-nav').hasClass('mini-sidebar')) {//菜单栏没有最小化
            $(this).parent("li").siblings("li.sidebar-item").children('ul').slideUp(200);
            if ($(this).next().css('display') == "none") { //展开
                //展开未展开
                $(this).next('ul').slideDown(200);
                $(this).parent('li').addClass('sidebar-show').siblings('li').removeClass('sidebar-show');
            }else{ //收缩
                //收缩已展开
                $(this).next('ul').slideUp(200);
                $(this).parent('li').removeClass('sidebar-show');
            }
        }
    });
    //菜单栏最小化
    $('#mini-button').on('click',function(){
        trigger_lsm_mini(false);

    });
    function trigger_lsm_mini(isNoAnim){
        if ($('.header-mini-btn input[type="checkbox"]').prop("checked")) {
            $('.sidebar-nav').removeClass('mini-sidebar');
            $('.sidebar-nav .change-href').attr('href','javascript:;');
            $('.sidebar-menu ul ul').css("display", "none");
            if(isNoAnim){
                $('.sidebar-nav').removeClass('animate-nav');
                $('.sidebar-nav').width(220);
            }
            else{
                $('.sidebar-nav').addClass('animate-nav');
                $('.sidebar-nav').stop().animate({width: 170},200);
            }
        }else{
            $('.sidebar-item.sidebar-show').removeClass('sidebar-show');
            $('.sidebar-menu ul').removeAttr('style');
            $('.sidebar-nav').addClass('mini-sidebar');
            $('.sidebar-nav .change-href').each(function(){$(this).attr('href',$(this).data('change'))});
            if(isNoAnim){
                $('.sidebar-nav').removeClass('animate-nav');
                $('.sidebar-nav').width(60);
            }
            else{
                $('.sidebar-nav').addClass('animate-nav');
                $('.sidebar-nav').stop().animate({width: 60},200);
            }
        }
    }
    //显示2级悬浮菜单
    $(document).on('mouseover','.mini-sidebar .sidebar-menu ul:first>li,.mini-sidebar .flex-bottom ul:first>li',function(){
        var offset = 2;
        if($(this).parents('.flex-bottom').length!=0)
            offset = -3;
        $(".sidebar-popup.second").length == 0 && ($("body").append("<div class='second sidebar-popup sidebar-menu-inner text-sm'><div></div></div>"));
        $(".sidebar-popup.second>div").html($(this).html());
        $(".sidebar-popup.second").show();
        var top = $(this).offset().top - $(window).scrollTop() + offset;
        var d = $(window).height() - $(".sidebar-popup.second>div").height();
        if(d - top <= 0 ){
            top  = d >= 0 ?  d - 8 : 0;
        }
        $(".sidebar-popup.second").stop().animate({"top":top}, 50);
    });
    //隐藏悬浮菜单面板
    $(document).on('mouseleave','.mini-sidebar .sidebar-menu ul:first, .mini-sidebar .slimScrollBar,.second.sidebar-popup',function(){
        $(".sidebar-popup.second").hide();
    });
    //常驻2级悬浮菜单面板
    $(document).on('mouseover','.mini-sidebar .slimScrollBar,.second.sidebar-popup',function(){
        $(".sidebar-popup.second").show();
    });

    //首页tab模式请求内容
    $(document).on('click', '.ajax-list a', function(event) {
        event.preventDefault();
        loadAjax( $(this), $(this).parents('.ajax-list') , '.'+$(this).data('target'));
    });

    $("input[name=term_name]").focus(function(){
        var this_input = $("input[name=term_id]");
        this_input.prop('checked', false);
    });
    $('.form_custom_term_id').on("click", function(event){
        $("input[name=term_name]").val("");
    });
    // 搜索模块 -----------------------
    function intoSearch() {
        if(window.localStorage.getItem("search_list")){
            $(".hide-type-list input#"+window.localStorage.getItem("search_list")).prop('checked', true);
            $(".hide-type-list input#m_"+window.localStorage.getItem("search_list")).prop('checked', true);
        }
        if(window.localStorage.getItem("search_list_menu")){
            $('.s-type-list.big label').removeClass('active');
            $(".s-type-list [data-id="+window.localStorage.getItem("search_list_menu")+"]").addClass('active');
        }
        toTarget($(".s-type-list.big"),false,false);
        $('.hide-type-list .s-current').removeClass("s-current");
        $('.hide-type-list input:radio[name="type"]:checked').parents(".search-group").addClass("s-current");
        $('.hide-type-list input:radio[name="type2"]:checked').parents(".search-group").addClass("s-current");

        $(".super-search-fm").attr("action",$('.hide-type-list input:radio:checked').val());
        $(".search-key").attr("placeholder",$('.hide-type-list input:radio:checked').data("placeholder"));
    }
    $(document).on('click', '.s-type-list label', function(event) {
        $('.s-type-list.big label').removeClass('active');
        $(this).addClass('active');
        window.localStorage.setItem("search_list_menu", $(this).data("id"));
        var parent = $(this).parents(".s-search");
        parent.find('.search-group').removeClass("s-current");
        parent.find('#'+$(this).attr("for")).parents(".search-group").addClass("s-current");
        toTarget($(this).parents(".s-type-list"),false,false);
    });
    $('.hide-type-list .search-group input').on('click', function() {
        var parent = $(this).parents(".s-search");
        window.localStorage.setItem("search_list", $(this).attr("id").replace("m_",""));
        parent.children(".super-search-fm").attr("action",$(this).val());
        parent.find(".search-key").attr("placeholder",$(this).data("placeholder"));

        if($(this).attr('id')=="type-zhannei" || $(this).attr('id')=="m_type-zhannei")
            parent.find(".search-key").attr("zhannei","true");
        else
            parent.find(".search-key").attr("zhannei","");

        parent.find(".search-key").select();
        parent.find(".search-key").focus();
    });
    $(document).on("submit", ".super-search-fm", function() {
        var key = encodeURIComponent($(this).find(".search-key").val())
        if(key == "")
            return false;
        else{
            window.open( $(this).attr("action") + key);
            return false;
        }
    });
    function getSmartTipsBaidu(value,parents) {
        $.ajax({
            type: "GET",
            url: "//sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su?cb=iowenHot",
            async: true,
            data: { wd: value },
            dataType: "jsonp",
            jsonp: "cb",
            success: function(res) {
                var list = parents.children(".search-smart-tips");
                list.children("ul").text("");
                tipsList = res.s.length;
                if (tipsList) {
                    for (var i = 0; i < tipsList; i++) {
                        list.children("ul").append("<li>" + res.s[i] + "</li>");
                        list.find("li").eq(i).click(function() {
                            var keyword = $(this).html();
                            parents.find(".smart-tips.search-key").val(keyword);
                            parents.children(".super-search-fm").submit();
                            list.slideUp(200);
                        });
                    }
                    list.slideDown(200);
                } else {
                    list.slideUp(200)
                }
            },
            error: function(res) {
                tipsList = 0;
            }
        })
    }
    var listIndex = -1;
    var parent;
    var tipsList = 0;
    var isZhannei = false;
    $(document).on("blur", ".smart-tips.search-key", function() {
        parent = '';
        $(".search-smart-tips").delay(150).slideUp(200)
    });
    $(document).on("focus", ".smart-tips.search-key", function() {
        isZhannei = $(this).attr('zhannei')!=''?true:false;
        parent = $(this).parents('#search');
        if ($(this).val() && !isZhannei) {
            switch(theme.hotWords) {
                case "baidu":
                    getSmartTipsBaidu($(this).val(),parent)
                    break;
                default:
            }
        }
    });
    $(document).on("keyup", ".smart-tips.search-key", function(e) {
        isZhannei = $(this).attr('zhannei')!=''?true:false;
        parent = $(this).parents('#search');
        if ($(this).val()) {
            if (e.keyCode == 38 || e.keyCode == 40 || isZhannei) {
                return
            }
            switch(theme.hotWords) {
                case "baidu":
                    getSmartTipsBaidu($(this).val(),parent)
                    break;
                default:
            }
            listIndex = -1;
        } else {
            $(".search-smart-tips").slideUp(200)
        }
    });
    $(document).on("keydown", ".smart-tips.search-key", function(e) {
        parent = $(this).parents('#search');
        if (e.keyCode === 40) {
            listIndex === (tipsList - 1) ? listIndex = 0 : listIndex++;
            parent.find(".search-smart-tips ul li").eq(listIndex).addClass("current").siblings().removeClass("current");
            var hotValue = parent.find(".search-smart-tips ul li").eq(listIndex).html();
            parent.find(".smart-tips.search-key").val(hotValue)
        }
        if (e.keyCode === 38) {
            if (e.preventDefault) {
                e.preventDefault()
            }
            if (e.returnValue) {
                e.returnValue = false
            }
            listIndex === 0 || listIndex === -1 ? listIndex = (tipsList - 1) : listIndex--;
            parent.find(".search-smart-tips ul li").eq(listIndex).addClass("current").siblings().removeClass("current");
            var hotValue = parent.find(".search-smart-tips ul li").eq(listIndex).html();
            parent.find(".smart-tips.search-key").val(hotValue)
        }
    });
    $('.nav-login-user.dropdown').hover(function(){
        if(!$(this).hasClass('show'))
            $(this).children('a').click();
    });
    $('#modal-new-url-summary').on('blur',function(){
        var t = $(this);
        if(t.val()!=''){
            t.removeClass('is-invalid');
        }
    });
})(jQuery);
function isPC() {
    let u = navigator.userAgent;
    let Agents = ["Android", "iPhone", "webOS", "BlackBerry", "SymbianOS", "Windows Phone", "iPad", "iPod"];
    let flag = true;
    for (let i = 0; i < Agents.length; i++) {
        if (u.indexOf(Agents[i]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

function toTarget(menu, padding, isMult) {
    var slider =  menu.children(".anchor");
    var target = menu.children(".hover").first() ;
    if (target && 0 < target.length){
    }
    else{
        if(isMult)
            target = menu.find('.active').parent();
        else
            target = menu.find('.active');
    }
    if(0 < target.length){
        if(padding)
        slider.css({
            left: target.position().left + target.scrollLeft() + "px",
            width: target.outerWidth() + "px",
            opacity: "1"
        });
        else
        slider.css({
            left: target.position().left + target.scrollLeft() + (target.outerWidth()/4) + "px",
            width: target.outerWidth()/2 + "px",
            opacity: "1"
        });
    }
    else{
        slider.css({
            opacity: "0"
        })
    }
}

/**
 * Minified by jsDelivr using Terser v5.3.5.
 * Original file: /npm/js-base64@3.6.0/base64.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):function(){const r=e.Base64,o=t();o.noConflict=()=>(e.Base64=r,o),e.Meteor&&(Base64=o),e.Base64=o}()}("undefined"!=typeof self?self:"undefined"!=typeof window?window:"undefined"!=typeof global?global:this,(function(){"use strict";const e="3.6.0",t="function"==typeof atob,r="function"==typeof btoa,o="function"==typeof Buffer,n="function"==typeof TextDecoder?new TextDecoder:void 0,a="function"==typeof TextEncoder?new TextEncoder:void 0,f=[..."ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="],i=(e=>{let t={};return e.forEach(((e,r)=>t[e]=r)),t})(f),c=/^(?:[A-Za-z\d+\/]{4})*?(?:[A-Za-z\d+\/]{2}(?:==)?|[A-Za-z\d+\/]{3}=?)?$/,u=String.fromCharCode.bind(String),s="function"==typeof Uint8Array.from?Uint8Array.from.bind(Uint8Array):(e,t=(e=>e))=>new Uint8Array(Array.prototype.slice.call(e,0).map(t)),d=e=>e.replace(/[+\/]/g,(e=>"+"==e?"-":"_")).replace(/=+$/m,""),l=e=>e.replace(/[^A-Za-z0-9\+\/]/g,""),h=e=>{let t,r,o,n,a="";const i=e.length%3;for(let i=0;i<e.length;){if((r=e.charCodeAt(i++))>255||(o=e.charCodeAt(i++))>255||(n=e.charCodeAt(i++))>255)throw new TypeError("invalid character found");t=r<<16|o<<8|n,a+=f[t>>18&63]+f[t>>12&63]+f[t>>6&63]+f[63&t]}return i?a.slice(0,i-3)+"===".substring(i):a},p=r?e=>btoa(e):o?e=>Buffer.from(e,"binary").toString("base64"):h,y=o?e=>Buffer.from(e).toString("base64"):e=>{let t=[];for(let r=0,o=e.length;r<o;r+=4096)t.push(u.apply(null,e.subarray(r,r+4096)));return p(t.join(""))},A=(e,t=!1)=>t?d(y(e)):y(e),b=e=>{if(e.length<2)return(t=e.charCodeAt(0))<128?e:t<2048?u(192|t>>>6)+u(128|63&t):u(224|t>>>12&15)+u(128|t>>>6&63)+u(128|63&t);var t=65536+1024*(e.charCodeAt(0)-55296)+(e.charCodeAt(1)-56320);return u(240|t>>>18&7)+u(128|t>>>12&63)+u(128|t>>>6&63)+u(128|63&t)},g=/[\uD800-\uDBFF][\uDC00-\uDFFFF]|[^\x00-\x7F]/g,B=e=>e.replace(g,b),x=o?e=>Buffer.from(e,"utf8").toString("base64"):a?e=>y(a.encode(e)):e=>p(B(e)),C=(e,t=!1)=>t?d(x(e)):x(e),m=e=>C(e,!0),U=/[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF]{2}|[\xF0-\xF7][\x80-\xBF]{3}/g,F=e=>{switch(e.length){case 4:var t=((7&e.charCodeAt(0))<<18|(63&e.charCodeAt(1))<<12|(63&e.charCodeAt(2))<<6|63&e.charCodeAt(3))-65536;return u(55296+(t>>>10))+u(56320+(1023&t));case 3:return u((15&e.charCodeAt(0))<<12|(63&e.charCodeAt(1))<<6|63&e.charCodeAt(2));default:return u((31&e.charCodeAt(0))<<6|63&e.charCodeAt(1))}},w=e=>e.replace(U,F),S=e=>{if(e=e.replace(/\s+/g,""),!c.test(e))throw new TypeError("malformed base64.");e+="==".slice(2-(3&e.length));let t,r,o,n="";for(let a=0;a<e.length;)t=i[e.charAt(a++)]<<18|i[e.charAt(a++)]<<12|(r=i[e.charAt(a++)])<<6|(o=i[e.charAt(a++)]),n+=64===r?u(t>>16&255):64===o?u(t>>16&255,t>>8&255):u(t>>16&255,t>>8&255,255&t);return n},E=t?e=>atob(l(e)):o?e=>Buffer.from(e,"base64").toString("binary"):S,v=o?e=>s(Buffer.from(e,"base64")):e=>s(E(e),(e=>e.charCodeAt(0))),D=e=>v(z(e)),R=o?e=>Buffer.from(e,"base64").toString("utf8"):n?e=>n.decode(v(e)):e=>w(E(e)),z=e=>l(e.replace(/[-_]/g,(e=>"-"==e?"+":"/"))),T=e=>R(z(e)),Z=e=>({value:e,enumerable:!1,writable:!0,configurable:!0}),j=function(){const e=(e,t)=>Object.defineProperty(String.prototype,e,Z(t));e("fromBase64",(function(){return T(this)})),e("toBase64",(function(e){return C(this,e)})),e("toBase64URI",(function(){return C(this,!0)})),e("toBase64URL",(function(){return C(this,!0)})),e("toUint8Array",(function(){return D(this)}))},I=function(){const e=(e,t)=>Object.defineProperty(Uint8Array.prototype,e,Z(t));e("toBase64",(function(e){return A(this,e)})),e("toBase64URI",(function(){return A(this,!0)})),e("toBase64URL",(function(){return A(this,!0)}))},O={version:e,VERSION:"3.6.0",atob:E,atobPolyfill:S,btoa:p,btoaPolyfill:h,fromBase64:T,toBase64:C,encode:C,encodeURI:m,encodeURL:m,utob:B,btou:w,decode:T,isValid:e=>{if("string"!=typeof e)return!1;const t=e.replace(/\s+/g,"").replace(/=+$/,"");return!/[^\s0-9a-zA-Z\+/]/.test(t)||!/[^\s0-9a-zA-Z\-_]/.test(t)},fromUint8Array:A,toUint8Array:D,extendString:j,extendUint8Array:I,extendBuiltins:()=>{j(),I()},Base64:{}};return Object.keys(O).forEach((e=>O.Base64[e]=O[e])),O}));
