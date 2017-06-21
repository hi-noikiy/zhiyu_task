<?php

namespace App\Http\Middleware;

use App\Modules\Manage\Model\ManagerModel;
use App\Modules\Manage\Model\PermissionRoleModel;
use App\Modules\Manage\Model\RoleUserModel;
use Closure;
use Illuminate\Support\Facades\Route;


class RolePermission
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
         * 默认第一条的用户拥有超级管理员的权限 $user->can(路由别名);
         *
         * 其他管理员需要分配角色 及用户组
         * 根据管理员所在的用户组，得到角色权限
         * 角色请求相应的路由别名，需要查询对应的权限
         *
         * 步骤：
         * 1 根据角色id 查询对应的角色 用户组
         * 2 根据用户组中权限查询权限详情中的具体所有权限
         * 3 根据请求的路由别名，查询是否拥有此别名的权限
         *
         * @return bool
         * */

        $route = Route::currentRouteName();
        //$route = $request->getRequestUri();
        //echo $route;
        $manager = ManagerModel::getManager();
        $user = $manager->username;
        $user = ManagerModel::where('username','=',$user)->first();
        if($manager->id !=  1) {
           if(!$user->can($route))
            return redirect()->back()->with(['message' => '没有权限']);
        }
        return $next($request);
    }
}
