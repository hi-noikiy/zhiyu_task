<?php

namespace App\Modules\User\Http\Controllers\Auth;

use App\DecrModel;
use App\Http\Controllers\IndexController;
use App\Modules\Manage\Model\AgreementModel;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\User\Http\Requests\LoginRequest;
use App\Modules\User\Http\Requests\RegisterRequest;
use App\Modules\User\Model\OauthBindModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use App\RemoteApiModel;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Theme;
use Crypt;
use Socialite;
use App\Modules\Advertisement\Model\AdTargetModel;
use App\Modules\Advertisement\Model\AdModel;

class AuthController extends IndexController
{

    


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    
    protected $redirectPath = '/user/index';

    
    protected $loginPath = '/login';

    

    public function __construct()
    {
        parent::__construct();
        $this->initTheme('auth');
        $this->theme->setTitle('职鱼');
        // 中间件 判断是否为登录状态
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    
    protected $code;

    protected function validator(array $data)
    {

    }

    
    protected function  create(array $data)
    {
        
        return UserModel::createUser($data);
    }


    /**
     * 加载前端登录页面
     */
    public function getLogin()
    {
        $code = \CommonClass::getCodes();
        $oauthConfig = ConfigModel::getConfigByType('oauth');
        
        $ad = AdTargetModel::getAdInfo('LOGIN_LEFT');

        $view = array(
            'code' => $code,
            'oauth' => $oauthConfig,
            'ad' => $ad
        );

        $this->theme->set('authAction', '欢迎登录');
        $this->theme->setTitle('欢迎登录');
        return $this->theme->scope('user.login', $view)->render();
    }

    /**
     * 验证前端登录
     */
    public function postLogin(LoginRequest $request)
    {
        $error = array();
        if ($request->get('code') && !\CommonClass::checkCode($request->get('code'))) {
            $error['code'] = '请输入正确的验证码';
        } else {
            /*if (!UserModel::checkPassword($request->get('username'), $request->get('password'))) {
                $error['password'] = '请输入正确的帐号或密码';
            } else {
                $user = UserModel::where('name', $request->get('username'))->first();
                if (!empty($user) && $user->status == 2){
                    $error['username'] = '该账户已禁用';
                }
            }*/


            $remoteUserData = array(
                'user_name' => $request->input('username'),
                'password' => $request->input('password'),
                'login_type' => 100,
                'login_ip' => $request->ip()
            );
            $userLoginRst = RemoteApiModel::userLogin($remoteUserData);
            if($userLoginRst['codes'] === 0){
                $userDetailInfo = UserDetailModel::where('uid', $userLoginRst['data']['id'])->first();
                if(!$userDetailInfo){
                    $UserAddData = array(
                        'uid' => $userLoginRst['data']['id'],
                        'mobile' => $userLoginRst['data']['mobile'],
                        'nickname' => $userLoginRst['data']['wx_nick'],
                        'avatar' => $userLoginRst['data']['avatar_url']
                    );
                    UserDetailModel::create($UserAddData);
                }

                $systemUserInfo = User::find($userLoginRst['data']['id']);
                if(!$systemUserInfo){
                    $systemUserCreateData = array(
                        'id' => $userLoginRst['data']['id'],
                        'name' => $userLoginRst['data']['wx_nick'],
                        'salt' => \CommonClass::random(4),
                        'status' => 1,
                        'validation_code' => \CommonClass::random(6),
                        'last_login_time' => date('Y-m-d H:i:s')
                    );
                    User::create($systemUserCreateData);
                }else{
                    $systemUserInfo->last_login_time = date('Y-m-d H:i:s');
                    $bool = $systemUserInfo->save();
                }



                $loginUserInfo = User::find($userLoginRst['data']['id']);
                Auth::login($loginUserInfo);

                

                setcookie('UserCookieUid', DecrModel::mc_encode($userLoginRst['data']['id']), time() + 7*24*3600, "/", "yjob.net");
                setcookie('UserCookieUinionid', DecrModel::mc_encode($userLoginRst['data']['wx_union_id']), time() + 7*24*3600, "/", "yjob.net");
                if(in_array($userLoginRst['data']['mobile'], Config::get('employer.employer'))){
                    $userLoginRst['data']['employer'] = $userLoginRst['data']['mobile'];
                }
                array_key_exists('avatarUrl', $userLoginRst['data']) && $userLoginRst['data']['avatar_url'] = $userLoginRst['data']['avatarUrl'];
                array_key_exists('avatar_url', $userLoginRst['data']) && $userLoginRst['data']['avatarUrl'] = $userLoginRst['data']['avatar_url'];
                Session::put('AuthUserInfo', $userLoginRst['data'], 7*24*60);
                return redirect("task");
            }else{
                $error['password'] = '请输入正确的帐号或密码';
            }
        }
        if (!empty($error)) {
            return redirect($this->loginPath())->withInput($request->only('username', 'remember'))->withErrors($error);
        }


        /*$throttles = $this->isUsingThrottlesLoginsTrait();
        $user = UserModel::where('email', $request->get('username'))->orWhere('name', $request->get('username'))->first();
        if ($user && !$user->status) {
            return redirect('waitActive/' . Crypt::encrypt($user->email))->withInput(array('email' => $request->get('email')));
        }
        Auth::loginUsingId($user->id);
        UserModel::where('email', $request->get('email'))->update(['last_login_time' => date('Y-m-d H:i:s')]);
        return $this->handleUserWasAuthenticated($request, $throttles);*/
    }

    /**
     * 加载注册页面
     */
    public function getRegister()
    {
        $code = \CommonClass::getCodes();
        
        $ad = AdTargetModel::getAdInfo('LOGIN_LEFT');
        
        $agree = AgreementModel::where('code_name','register')->first();

        $view = array(
            'code' => $code,
            'ad' => $ad,
            'agree' => $agree
        );
        $this->initTheme('auth');
        $this->theme->set('authAction', '欢迎注册');
        $this->theme->setTitle('欢迎注册');
        return $this->theme->scope('user.register', $view)->render();
    }

    /**
     * 验证注册
     */
    public function postRegister(RegisterRequest $request)
    {
        
        if ($this->create($request->all())){
            return redirect('waitActive/' . Crypt::encrypt($request->get('email')));
        }
        return back()->with(['message' => '注册失败']);
    }

    /**
     * 验证激活注册
     */
    public function activeEmail($validationInfo)
    {
        $info = Crypt::decrypt($validationInfo);
        $user = UserModel::where('email', $info['email'])->where('validation_code', $info['validationCode'])->first();

        $this->initTheme('auth');
        $this->theme->set('authAction', '欢迎注册');
        $this->theme->setTitle('欢迎注册');
        
        if ($user && time() > strtotime($user->overdue_date) || !$user) {
            return $this->theme->scope('user.activefail')->render();
        }
        
        $user->status = 1;
        $user->email_status = 2;
        $status = $user->save();
        if ($status){
            Auth::login($user);
            return $this->theme->scope('user.activesuccess')->render();
        }
    }

    /**
     * 成功注册时的提示
     *
     * 点击进入邮箱进行激活操作
     */
    public function waitActive($email)
    {
        $email = Crypt::decrypt($email);

        $emailType = substr($email, strpos($email, '@') + 1);
        $view = array(
            'email' => $email,
            'emailType' => $emailType
        );
        $this->initTheme('auth');
        $this->theme->set('authAction', '欢迎注册');
        $this->theme->setTitle('欢迎注册');
        return $this->theme->scope('user.waitactive', $view)->render();
    }


    /**
     * 注册时刷新验证码
     */
    public function flushCode()
    {
        $code = \CommonClass::getCodes();

        return \CommonClass::formatResponse('刷新成功', 200, $code);
    }

    /**
     * 注册时ajax验证用户名是否已被注册
     */
    public function checkUserName(Request $request)
    {
        $username = $request->get('param');

        $status = UserModel::where('name', $username)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '用户名不可用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    /**
     * 注册时ajax验证邮箱是否已被注册
     */
    public function checkEmail(Request $request)
    {
        $email = $request->get('param');

        $status = UserModel::where('email', $email)->first();
        if (empty($status)){
            $status = 'y';
            $info = '';
        } else {
            $info = '邮箱已占用';
            $status = 'n';
        }
        $data = array(
            'info' => $info,
            'status' => $status
        );
        return json_encode($data);
    }

    /**
     * 重新发送注册邮件
     */
    public function reSendActiveEmail($email)
    {
        $email = Crypt::decrypt($email);
        $status = UserModel::where('email', $email)->update(array('overdue_date' => date('Y-m-d H:i:s', time() + 60*60*3)));
        if ($status){
            $status = \MessagesClass::sendActiveEmail($email);
            if ($status){
                $msg = 'success';
            } else {
                $msg = 'fail';
            }
            return \CommonClass::formatResponse($msg);
        }
    }

    /**
     * 第三方登录
     */
    public function oauthLogin($type)
    {
        switch ($type){
            case 'qq':
                $alias = 'qq_api';
                break;
            case 'weibo':
                $alias = 'sina_api';
                break;
            case 'weixinweb':
                $alias = 'wechat_api';
                break;
        }
        
        $oauthConfig = ConfigModel::getOauthConfig($alias);
        $clientId = $oauthConfig['appId'];
        $clientSecret = $oauthConfig['appSecret'];
        $redirectUrl = url('oauth/' . $type . '/callback');
        $config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl);
        return Socialite::with($type)->setConfig($config)->rediirect();
    }

    /**
     * 验证第三方登录回调
     */
    public function handleOAuthCallBack($type)
    {

        switch ($type){
            case 'qq':
                $service = 'qq_api';
                break;
            case 'weibo':
                $service = 'sina_api';
                break;
            case 'weixinweb':
                $service = 'wechat_api';
                break;
        }
        $oauthConfig = ConfigModel::getOauthConfig($service);
        Config::set('services.' . $type . '.client_id', $oauthConfig['appId']);
        Config::set('services.' . $type . '.client_secret', $oauthConfig['appSecret']);
        Config::set('services.' . $type . '.redirect', url('oauth/' . $type . '/callback'));

        $user = Socialite::driver($type)->user();

        $userInfo = [];
        switch ($type){
            case 'qq':
                $userInfo['oauth_id'] = $user->id;
                $userInfo['oauth_nickname'] = $user->nickname;
                $userInfo['oauth_type'] = 0;
                break;
            case 'weibo':
                $userInfo['oauth_id'] = $user->id;
                $userInfo['oauth_nickname'] = $user->nickname;
                $userInfo['oauth_type'] = 1;
                break;
            case 'weixinweb':
                $userInfo['oauth_nickname'] = $user->nickname;
                $userInfo['oauth_id'] = $user->user['unionid']; 
                $userInfo['oauth_type'] = 2;
                break;
        }
        
        $oauthStatus = OauthBindModel::where(['oauth_id' => $userInfo['oauth_id'], 'oauth_type' => $userInfo['oauth_type']])
                    ->first();
        if (!empty($oauthStatus)){
            Auth::loginUsingId($oauthStatus->uid);
        } else {
            
            $uid = OauthBindModel::oauthLoginTransaction($userInfo);
            Auth::loginUsingId($uid);
        }
        return redirect()->intended($this->redirectPath());
    }

}
