<?php

namespace App\Http\Middleware;

use Closure;

class NoAccess
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
        /**
         * 控制不允许访问的路由
         * */
        return redirect('/')->withError('对不起，您访问的地址，暂未开放！');
        //return $next($request);
    }
}
