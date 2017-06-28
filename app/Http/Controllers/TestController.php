<?php

namespace App\Http\Controllers;

use App\DecrModel;
use App\Modules\Task\Model\TaskModel;
use App\RemoteApiModel;
use App\Test;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailer;
use Illuminate\Support\Facades\Session;
use Theme;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $s = Session::get('AuthUserInfo');
        dd($s);
        dd(Auth::user());

        $createData = array(
            'id' => 33,
            'name' => 'mc',
            'salt' => \CommonClass::random(4),
            'status' => 1,
            'validation_code' => \CommonClass::random(6),
            'last_login_time' => time()
        );
        //$rst = User::create($createData);
        $res = User::find(2);
        dd($res);
        dd($createData);
        /*$remoteData = array(
            'task_id'    => 1111,
            'task_name'  => '任务名2',
            'task_money' => 2,
            'uid'        => 12906
        );
        $userInfo = RemoteApiModel::taskSystemtaskSystemRemote($remoteData);
        dd($userInfo);
        */

        dd($_COOKIE);
    }
    public function index1(Request $request){
        $mail = "machuang2264@163.com";

        $bool = $this->dispatch(new SendEmailer($mail));
        dd($bool);
    }
    public function index2(Request $request, $id){
        dd('index2:' . $id . '$request->id:' . $request->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
