<?php

namespace App\Http\Middleware;

use App\DecrModel;
use App\Modules\User\Model\UserModel;
use App\RemoteApiModel;
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
        if(!Session::has('AuthUserInfo')){
            $Udata = array(
                'plateForm' => 101,
                'unionId' => DecrModel::mc_decode($_COOKIE['UserCookieUinionid'])
            );
            $userInfo = RemoteApiModel::userInfo($Udata);
            if($userInfo['codes'] === 0){
                if(in_array($userInfo['data']['mobile'], Config::get('employer.employer'))){
                    $userInfo['data']['employer'] = $userInfo['data']['mobile'];
                }
                $userInfo['data']['wx_nick'] = $userInfo['data']['wxNickName'];
                Session::put('AuthUserInfo', $userInfo['data'], 7*24*60);
            }else{
                return redirect()->guest('/login');
            }
        }
        if(Session::has('AuthUserInfo')){
            return $next($request);
        }else{
            return redirect()->guest('/login');
        }
    }
}
