<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    // 自定义登录view模板
    protected $view = 'admin.login';

    public function postLogin(Request $request)
    {
        $reqOnlyArr = [$this->username(), 'password'];
        $validatorArr = [$this->username() => 'required', 'password' => 'required'];
        if (!env('CAPTCHA_DISABLE')) {
            $reqOnlyArr[] = "captcha";
            $validatorArr["captcha"] = 'required|captcha';
        }
        $credentials = $request->only($reqOnlyArr);
        $remember = (bool) $request->input('remember', false);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, $validatorArr,['captcha' => '验证码错误']);

        if ($validator->fails()) {
            return $this->validationErrorsResponse($validator);
        }
        if (isset($credentials['captcha'])) unset($credentials['captcha']);
        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return $this->validationErrorsResponse([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }
}
