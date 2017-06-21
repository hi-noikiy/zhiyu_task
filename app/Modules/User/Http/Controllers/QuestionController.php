<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Requests;
use App\Modules\Question\Models\AnswerModel;
use App\Modules\Question\Models\QuestionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends UserCenterController
{
    public function __construct()
    {
        parent::__construct();
        $this->initTheme('accepttask');//主题初始化
    }

    /**
     * 我的回答
     * @param Request $request
     * @return mixed
     */
    public function myAnswer(Request $request)
    {
        $this->theme->setTitle('我的回答');
        $this->theme->set('TYPE',3);
        $uid = Auth::user()['uid'];
        $data = $request->all();
        //查询我的回答
        $myanwser = AnswerModel::myAnwser($uid,$data);
        $myanwser_toArray = $myanwser->toArray();
        $domain = url();

        $view  = [
            'myanwser'=>$myanwser,
            'myanwser_toArray'=>$myanwser_toArray,
            'domain'=>$domain
        ];
        return $this->theme->scope('user.quetion.myAnswer',$view)->render();
    }

    /**
     * 我的提问
     * @param Request $request
     * @return mixed
     */
    public function myQuestion(Request $request)
    {
        $this->theme->setTitle('我的提问');
        $this->theme->set('TYPE',3);
        $uid = Auth::user()['uid'];
        $data = $request->all();

        //查询我的回答
        $myquestion = QuestionModel::myQuestion($uid,$data);
        $myquestion_toArray = $myquestion->toArray();
        $domian=url();
        $view = [
            'myquestion'=>$myquestion,
            'myquestion_toArray'=>$myquestion_toArray,
            'domain'=>$domian
        ];
        return $this->theme->scope('user.quetion.myquestion',$view)->render();
    }

}
