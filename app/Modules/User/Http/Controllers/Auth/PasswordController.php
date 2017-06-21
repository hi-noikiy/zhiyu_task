<?php

namespace App\Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\IndexController;
use App\Modules\User\Http\Requests\PasswordEmailRequest;
use App\Modules\User\Http\Requests\ResetRequest;
use App\Modules\User\Model\UserModel;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use Theme;

class PasswordController extends IndexController
{
    


    use ResetsPasswords;

    protected $redirectTo = '/user';

    

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * 记载找回密码页面
     */
    public function getEmail()
    {
        $code = \CommonClass::getCodes();
        $view = array(
            'code' => $code
        );
        $this->theme->set('authAction', '找回密码');
        $this->initTheme('auth');
        $this->theme->setTitle('找回密码');
        return $this->theme->scope('user.password', $view)->render();
    }


    /**
     * 验证找回密码数据
     */
    public function postEmail(PasswordEmailRequest $request)
    {
        $error = array();
        if (!\CommonClass::checkCode($request->get('code'))) {
            $error['code'] = '请输入正确的验证码';
        } else {
            $user = UserModel::where('email', $request->get('email'))->first();
            if(!$user){
                $error['email'] = '邮箱未注册';
            } elseif (!$user->status) {
                $error['email'] = '账号未激活';
            }
        }

        if (!empty($error)) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        $status = \MessagesClass::sendPasswordEmail($request->get('email'));
        if ($status) {
            return redirect('waitValidation/' . Crypt::encrypt($request->get('email')));
        }
    }


    /**
     * 成功发送邮件，加载找回密码
     */
    public function postReset(ResetRequest $request)
    {
        $validation = Crypt::decrypt($request->get('validation'));
        $email = $validation['email'];
        $user = UserModel::where('email', $email)->first();
        $user->password = UserModel::encryptPassword($request->get('password'), $user->salt);
        $status = $user->save();
        $this->initTheme('auth');
        $this->theme->set('authAction', '找回密码');
        $this->theme->setTitle('找回密码');
        if ($status)
            return $this->theme->scope('user.resetsuccess')->render();
    }


    /**
     * 加载找回密码，成功发送邮件
     */
    public function waitValidation($email)
    {
        $email = Crypt::decrypt($email);
        $view = array(
            'email' => $email,
            'emailType' => substr($email, strpos($email, '@') + 1)
        );
        $this->initTheme('auth');
        $this->theme->set('authAction', '找回密码');
        $this->theme->setTitle('找回密码');
        return $this->theme->scope('user.waitvalidation', $view)->render();
    }

    /**
     * 成功发送邮件，加载验证通过，5秒后跳转首页 的页面
     */
    public function resetValidation($validationInfo)
    {
        $info = Crypt::decrypt($validationInfo);
        $user = UserModel::where('email', $info['email'])->where('reset_password_code', $info['resetPasswordCode'])->first();

        $this->initTheme('auth');
        if (!$user || $user && time() > strtotime($user->expire_date)){
            return $this->theme->scope('user.passwordfail')->render();
        }
        $view = array(
            'validationInfo' => $validationInfo
        );
        $this->theme->setTitle('找回密码');
        return $this->theme->scope('user.resetpassword', $view)->render();
    }

    /**
     * ajax 验证邮箱状态
     */
    public function checkEmail(Request $request)
    {
        $email = $request->get('param');

        $status = UserModel::where('email', $email)->first();
        if (empty($status)){
            $status = 'n';
            $info = '邮箱未注册';
        } else {
            $info = '';
            $status = 'y';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    /**
     * ajax验证验证码
     */
    public function checkCode(Request $request)
    {
        $code = $request->get('param');

        if (!\CommonClass::checkCode($code)){
            $data = array(
                'info' => '验证码错误',
                'status' => 'n'
            );
        } else {
            $data = array(
                'info' => '',
                'status' => 'y'
            );
        }
        return json_encode($data);
    }

    /**
     * 重新发送找回密码
     */
    public function reSendPasswordEmail($email)
    {
        $email = Crypt::decrypt($email);
        $status = \MessagesClass::sendPasswordEmail($email);

        if ($status)
            return \CommonClass::formatResponse('success');
    }
}
