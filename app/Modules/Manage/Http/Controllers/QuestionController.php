<?php

namespace App\Modules\Manage\Http\Controllers;

use App\Http\Controllers\ManageController;
use App\Http\Requests;
use App\Modules\Question\Models\AnswerModel;
use App\Modules\Question\Models\QuestionCategoryModel;
use App\Modules\Question\Models\QuestionModel;
use Illuminate\Http\Request;

class QuestionController extends ManageController
{
    public function __construct()
    {
        parent::__construct();
        $this->initTheme('manage');
        $this->theme->set('manageType', 'agreement');

    }

    /**
     * 问题列表
     * @return mixed
     */
    public function getList(Request $request)
    {
        $this->theme->setTitle('问答列表');
        $data = $request->all();
        $question = QuestionModel::allQuestion($data);
        //查询问答一级分类
        $category_first = QuestionCategoryModel::where('pid',0)->get()->toArray();
        //查询二级分类
        $category_second = [];
        if($category_first)
            $category_second = QuestionCategoryModel::where('pid',$category_first[0]['id'])->get()->toArray();
        $map = [
            0=>'全部',
            1=>'等待处理',
            2=>'审核失败',
            3=>'未解决',
            4=>'已解决',
        ];
        $view = [
            'question'=>$question,
            'category_first'=>$category_first,
            'category_second'=>$category_second,
            'map'=>$map,
        ];
        return $this->theme->scope('manage.questionList',$view)->render();

    }

    /**
     * 审核成功或失败
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($id,$status)
    {
        switch($status){
            case 1:
                $status_real = 2;
                break;
            case 2:
                $status_real = 5;
                break;
            default:
                $status_real = 2;
                break;
        }
        $result = QuestionModel::where('id',$id)->update(['status'=>$status_real,'verify_at'=>date('Y-m-d H:i:s',time())]);

        if(!$result)
            return redirect()->back()->with(['error'=>'操作失败']);

        return redirect()->back()->with(['error'=>'操作成功！']);
    }

    /**
     * 问题详情
     * @param $id
     * @return mixed
     */
    public function getDetail($id)
    {
        $this->theme->setTitle('问答详情');
        $detail = QuestionModel::select('question.*','us.name as username')
            ->where('question.id',$id)
            ->join('users as us','us.id','=','question.uid')
            ->leftjoin('question_category as qy','qy.id','=','question.category')
            ->first();
        //获取上一项id
        $preId = QuestionModel::where('id', '>', $id)->min('id');
        //获取下一项id
        $nextId = QuestionModel::where('id', '<', $id)->max('id');
        //查询问答一级分类
        $category_first = QuestionCategoryModel::where('pid',0)->get()->toArray();
        //查询二级分类
        $category_second = [];
        if($category_first)
            $category_second = QuestionCategoryModel::where('pid',$category_first[0]['id'])->get()->toArray();
        $map = [
            0=>'待审核',
            1=>'待审核',
            2=>'审核通过',
            3=>'已回答',
            4=>'已采纳',
            5=>'审核失败'
        ];
        $type=1;
        $view = [
            'detail'=>$detail,
            'category_first'=>$category_first,
            'category_second'=>$category_second,
            'map'=>$map,
            'preId'=>$preId,
            'nextId'=>$nextId,
            'type'=>$type,
            'id'=>$id
        ];
        return $this->theme->scope('manage.questionDetail',$view)->render();
    }

    /**
     * 修改
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDetail(Request $request)
    {
        $data = $request->except('_token');
        $question = [
            'discription'=>$data['discription'],
            'category'=>intval($data['category'])
        ];
        //修改quetion
        $result = QuestionModel::where('id',$data['id'])->update($question);

        if(!$result)
            return redirect()->back()->with(['error'=>'修改失败！']);

        return redirect()->back()->with(['message'=>'修改成功！']);
    }

    public function getDetailAnswer($id)
    {
        $answer = AnswerModel::select('answer.*','us.name as username','qt.discription','qt.status as question_status')
            ->where('answer.questionid',$id)
            ->join('users as us','us.id','=','answer.uid')
            ->leftjoin('question as qt','qt.id','=','answer.questionid')
            ->get();
        $type=2;
        $view = [
            'answer'=>$answer,
            'type'=>$type,
            'id'=>$id
        ];
        return $this->theme->scope('manage.questionDetail',$view)->render();
    }

    public function getConfig()
    {

    }

    public function postConfig(Request $request)
    {

    }

    /**
     * 问题类型切换
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxCategory($id)
    {
        $category = QuestionCategoryModel::where('pid',$id)->toJson();
        if(!$category)
            return response()->json(['errMsg' => '参数错误！','errCode'=>1]);

        return $category;
    }

    public function questionDelete($id)
    {
        $result = QuestionModel::where('id',$id)->delete();

        if(!$result)
            return redirect()->back()->with(['error'=>'删除失败！']);

        return redirect()->back()->with(['message'=>'删除成功！']);
    }
}
