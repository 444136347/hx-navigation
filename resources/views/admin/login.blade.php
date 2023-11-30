<style>
    .row {
        margin: 0;
    }

    .col-md-12,
    .col-md-3 {
        padding: 0;
    }

    @media screen and (min-width: 1000px) and (max-width: 1150px) {
        .col-lg-3,
        .col-lg-9 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media screen and (min-width: 1151px) and (max-width: 1300px) {
        .col-lg-3 {
            flex: 0 0 40%;
            max-width: 40%;
        }

        .col-lg-9 {
            flex: 0 0 60%;
            max-width: 60%;
        }
    }

    @media screen and (min-width: 1301px) and (max-width: 1700px) {
        .col-lg-3 {
            flex: 0 0 35%;
            max-width: 35%;
        }

        .col-lg-9 {
            flex: 0 0 65%;
            max-width: 65%;
        }
    }

    .login-page {
        height: auto;
    }

    .login-main {
        position: relative;
        display: flex;
        min-height: 100vh;
        flex-direction: row;
        align-items: stretch;
        margin: 0;
    }

    .login-main .login-page {
        background-color: #fff;
    }

    .login-main .card {
        box-shadow: none;
    }

    .login-main .auth-brand {
        margin: 4rem 0 4rem;
        font-size: 26px;
        width: 325px;
    }

    @media (max-width: 576px) {
        .login-main .auth-brand {
            width: 90%;
            margin-left: 24px
        }
    }

    .login-main .login-logo {
        font-size: 2.1rem;
        font-weight: 300;
        margin-bottom: 0.9rem;
        text-align: left;
        margin-left: 20px;
    }

    .login-main .login-box-msg {
        margin: 0;
        padding: 0 0 20px;
        font-size: 0.9rem;
        font-weight: 400;
        text-align: left;
    }

    .login-main .btn {
        width: 100%;
    }

    .login-page-right {
        padding: 6rem 3rem;
        flex: 1;
        position: relative;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.3);
        text-align: center !important;
        background: url(/vendor/other/images//login_bg.jpg) center;
        background-size: cover;
    }

    .login-description {
        position: absolute;
        margin: 0 auto;
        padding: 0 1.75rem;
        color: #0a0a0a;
        top: 3rem;
        left: 0;
        right: 0;
    }

    .content-front {
        position: absolute;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, .1);
        margin-top: -6rem;
    }

    body.dark-mode .content-front {
        background: rgba(0, 0, 0, .3);
    }

    body.dark-mode .auth-brand {
        color: #cacbd6
    }

    .form-control-captcha {
        width: 61%;
    }

    .captcha-img-login {
        width: 37%;
        height: 33.5px;
        position: absolute;
        top: 0;
        right: 0;
        border-radius: .25rem;
        border: 1px solid #dbe3e6;
    }

    .captcha-img-login div img {
        top: 0;
        right: 0;
        border-radius: .25rem;
    }

    .loading-div {
        display: none;
        width: 33px;
        height: 33px;
        margin: auto;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
    }
</style>

<div class="row login-main">
    <div class="col-lg-3 col-12 bg-white">
        <div class="login-page">
            <div class="auth-brand text-lg-left">
                {!! config('admin.logo') !!}
            </div>

            <div class="login-box">
                <div class="login-logo mb-2">
                    <p class="login-box-msg mt-1 mb-1">{{ __('admin.welcome_back') }}</p>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">

                        <form id="login-form" method="POST" action="{{ admin_url('auth/login') }}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                <input
                                        type="text"
                                        class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                        name="username"
                                        placeholder="{{ trans('admin.username') }}"
                                        value="admin"
                                        required
                                        autofocus
                                >

                                <div class="form-control-position">
                                    <i class="feather icon-user"></i>
                                </div>

                                <label for="email">{{ trans('admin.username') }}</label>

                                <div class="help-block with-errors"></div>
                                @if($errors->has('username'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                                    @foreach($errors->get('username') as $message)
                                            <span class="control-label" for="inputError"><i
                                                        class="feather icon-x-circle"></i> {{$message}}</span><br>
                                        @endforeach
                                                </span>
                                @endif
                            </fieldset>

                            <fieldset class="form-label-group form-group position-relative has-icon-left">
                                <input
                                        minlength="5"
                                        maxlength="20"
                                        id="password"
                                        type="password"
                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                        name="password"
                                        placeholder="{{ trans('admin.password') }}"
                                        required
                                        value="admin"
                                        autocomplete="current-password"
                                >

                                <div class="form-control-position">
                                    <i class="feather icon-lock"></i>
                                </div>
                                <label for="password">{{ trans('admin.password') }}</label>

                                <div class="help-block with-errors"></div>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                                    @foreach($errors->get('password') as $message)
                                            <span class="control-label" for="inputError"><i
                                                        class="feather icon-x-circle"></i> {{$message}}</span><br>
                                        @endforeach
                                                    </span>
                                @endif

                            </fieldset>

                            <fieldset class="form-label-group form-group position-relative has-icon-left" id="captcha">
                                <input
                                        class="form-control form-control-captcha" id="captcha-input" name="captcha"
                                        placeholder="请输入验证码"
                                        required
                                        type="text"
                                >
                                <div class="captcha-img-login">
                                    <img src="{{ captcha_src('mini') }}" alt="captcha" class="captcha-img"
                                         data-refresh-config="mini">
                                </div>
                                <div class="spinner-border text-secondary loading-div" id="loading-div">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="form-control-position"><i class="feather icon-image"></i></div>
                                <div class="help-block with-errors"></div>
                                @if($errors->has('captcha'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                                    @foreach($errors->get('captcha') as $message)
                                            <span class="control-label" for="inputError"><i
                                                        class="feather icon-x-circle"></i> {{$message}}</span><br>
                                        @endforeach
                                                    </span>
                                @endif
                            </fieldset>

                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="text-left">
                                    <fieldset class="checkbox">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input id="remember" name="remember" value="1"
                                                   type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                  <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                            <span> {{ trans('admin.remember_me') }}</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right login-btn">
                                {{ __('admin.login') }}
                                &nbsp;
                                <i class="feather icon-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-12 login-page-right">
        <div class="login-description">
            <p class="lead">
                发现更多，分享无限。
            </p>
            <p class="lead">
                慧信导航，链接你我世界。
            </p>
        </div>
    </div>
</div>


<script>
  Dcat.ready(function () {
    // ajax表单提交
    $('#login-form').form({
      validate: true,
      after: function () {
        loadingEvent()
      }
    });
  });
  $('img.captcha-img').on('click', function () {
    loadingEvent()
  });

  function loadingEvent() {
    const loadingDiv = $("#loading-div");
    const captchaDiv = $(".captcha-img-login");
    const captcha = $('.captcha-img');
    captchaDiv.css("display", "none");
    loadingDiv.css("display", "block");
    var config = captcha.data('refresh-config');
    if (config === undefined) config = "mini"
    $.ajax({
      method: 'GET',
      url: '/get_captcha/' + config,
    }).done(function (response) {
      captcha.prop('src', response);
      captchaDiv.css("display", "block");
      loadingDiv.css("display", "none");
    });
  }
</script>
