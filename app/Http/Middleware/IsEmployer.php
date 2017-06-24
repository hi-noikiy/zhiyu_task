<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class IsEmployer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(in_array(Session::get('AuthUserInfo.mobile'), Config::get('employer.employer'))){
            return $next($request);
        }else{
            return redirect('task')->withError('你没有操作权限！');
        }
    }
}
