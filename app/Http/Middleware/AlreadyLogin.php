<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AlreadyLogin
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
        if(Session::has('AuthUserInfo')){
            if(Route::currentRouteName() == 'loginCreatePage'){
                return redirect("/");
            }
            return $next($request);
        }

        if(Route::currentRouteName() == 'loginCreatePage'){
            return $next($request);
        }else{
            return redirect("login");
        }
    }
}
