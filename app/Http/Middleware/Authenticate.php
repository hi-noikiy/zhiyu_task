<?php

namespace App\Http\Middleware;

use App\DecrModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use App\RemoteApiModel;
use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /*
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // =====================Old============================
        /*
         if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/login');
            }
        }

        if (UserModel::find(Auth::id())->status == 2){
            return redirect('logout');
        }

        return $next($request);
        */
        // ==================================================


        if(!array_key_exists('UserCookieUinionid', $_COOKIE)){
            return redirect()->guest('/login');
        }
        $isAlready = false;
        if(!Session::has('AuthUserInfo')){
            $Udata = array(
                'plateForm' => 101,
                'unionId' => DecrModel::mc_decode($_COOKIE['UserCookieUinionid'])
            );
            $userInfo = RemoteApiModel::userInfo($Udata);
            if($userInfo['codes'] === 0){
                $userDetailInfo = UserDetailModel::where('uid', $userInfo['data']['id'])->first();
                if(!$userDetailInfo){
                    $UserAddData = array(
                        'uid' => $userInfo['data']['id'],
                        'mobile' => $userInfo['data']['mobile'],
                        'nickname' => $userInfo['data']['wxNickName'],
                        'avatar' => $userInfo['data']['avatarUrl']
                    );
                    UserDetailModel::create($UserAddData);
                }

                $systemUserInfo = User::find($userInfo['data']['id']);
                if(!$systemUserInfo){
                    $systemUserCreateData = array(
                        'id' => $userInfo['data']['id'],
                        'name' => $userInfo['data']['wxNickName'],
                        'salt' => \CommonClass::random(4),
                        'status' => 1,
                        'validation_code' => \CommonClass::random(6),
                        'last_login_time' => date('Y-m-d H:i:s')
                    );
                    User::create($systemUserCreateData);
                }


                $loginUserInfo = User::find($userInfo['data']['id']);
                Auth::login($loginUserInfo);



                if(in_array($userInfo['data']['mobile'], Config::get('employer.employer'))){
                    $userInfo['data']['employer'] = $userInfo['data']['mobile'];
                }
                array_key_exists('wxNickName', $userInfo['data']) && $userInfo['data']['wx_nick'] = $userInfo['data']['wxNickName'];
                array_key_exists('wxNickName', $userInfo['data']) && $userInfo['data']['nick_name'] = $userInfo['data']['wxNickName'];
                array_key_exists('avatarUrl', $userInfo['data']) && $userInfo['data']['avatar_url'] = $userInfo['data']['avatarUrl'];
                array_key_exists('avatar_url', $userInfo['data']) && $userInfo['data']['avatarUrl'] = $userInfo['data']['avatar_url'];
                Session::put('AuthUserInfo', $userInfo['data'], 7*24*60);
                $isAlready = true;
            }else{
                return redirect()->guest('/login');
            }
        }
        if(Session::has('AuthUserInfo') || $isAlready){
            return $next($request);
        }else{
            return redirect()->guest('/login');
        }
    }
}
