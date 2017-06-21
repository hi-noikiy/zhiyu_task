<?php


namespace App\Modules\Api\Http\Controllers;

use App\Http\Controllers\ApiBaseController;
use App\Modules\Task\Model\TaskAttachmentModel;
use App\Modules\Task\Model\TaskCateModel;
use App\Modules\Task\Model\TaskModel;
use App\Modules\Task\Model\TaskRightsModel;
use App\Modules\Task\Model\WorkAttachmentModel;
use App\Modules\Task\Model\WorkCommentModel;
use App\Modules\Task\Model\WorkModel;
use App\Modules\User\Model\AttachmentModel;
use App\Modules\User\Model\CommentModel;
use App\Modules\User\Model\DistrictModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\User\Model\UserModel;
use App\Modules\Task\Model\TaskTypeModel;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Crypt;
use DB;

class TaskController extends ApiBaseController
{
    protected $uid;

    public function __construct(Request $request)
    {
        $tokenInfo = Crypt::decrypt(urldecode($request->get('token')));
        $this->uid = $tokenInfo['uid'];
    }

    
    public function getTaskList(Request $request)
    {
        $data = $request->all();
        $data['limit'] = (isset($data['limit'])&&$data['limit']) ? $data['limit'] : 15;
        $tasks = TaskModel::whereIn('task.status',[2,3,4,5,6,7,8,9,10,11])
            ->select('task.*','cate.name as cate_name')
            ->leftjoin('cate','task.cate_id','=','cate.id');
        if(isset($data['cate_id']) && $data['cate_id']){
            $tasks = $tasks->where('task.cate_id',$data['cate_id']);
        }
        if(isset($data['type']) && $data['type']){
            switch($data['type']){
                case 1:
                    $tasks = $tasks->orderBy('task.id','desc');
                    break;
                case 2:
                    $tasks = $tasks->orderBy('task.view_count','desc');
                    break;
                case 3:
                    $tasks = $tasks->orderBy('task.bounty','desc');
                    break;
                case 4:
                    $tasks = $tasks->orderBy('task.delivery_deadline','desc');
                    break;
            }
        }

        $tasks = $tasks->paginate($data['limit'])->toArray();
        if($tasks['total']){
            return $this->formateResponse(1000,'success',$tasks);
        }else{
            return $this->formateResponse(2001,'暂无对应搜索条件的结果');
        }
    }

    
    public function myPubTasks(Request $request)
    {
        $data = $request->all();
        $data['limit'] = (isset($data['limit'])&&$data['limit']) ? $data['limit'] : 10;
        $tasks = TaskModel::select('task.*','cate.name as cate_name')
            ->leftjoin('cate','task.cate_id','=','cate.id')
            ->where('task.uid',$this->uid);

        if (isset($data['status']) && $data['status']){
            switch($data['status']){
                case 1:
                    $status = [3,4,6];
                    break;
                case 2:
                    $status = [5];
                    break;
                case 3:
                    $status = [7];
                    break;
                case 4:
                    $status = [8,9,10];
                    break;
                default:
                    $status = [2,3,4,5,6,7,8,9,10,11];
            }
            $tasks = $tasks->whereIn('task.status',$status);
        }

        $tasks = $tasks->where('task.status','>=',2)->where('task.status','<=',11)->orderBy('task.created_at','desc')->paginate($data['limit'])->toArray();
        if($tasks['total']){
            $status = [
                    2=>'审核中',
                    3=>'定时发布',
                    4=>'投稿中',
                    5=>'选稿中',
                    6=>'选稿中',
                    7=>'交付中',
                    8=>'待评价',
                    9=>'已结束',
                    10=>'已结束',
                    11=>'维权中'
            ];
            if(isset($data['status'])){
                $tasks['workStatus'] = $data['status'];
            } else{
                $tasks['workStatus'] = 0;
            }
            foreach($tasks['data'] as $k=>$v){
                $tasks['data'][$k]['status'] = $status[$v['status']];
            }
        }
        return $this->formateResponse(1000,'success',$tasks);
    }

    
    public function myAcceptTask(Request $request)
    {
        $data = $request->all();
        $data['limit'] = (isset($data['limit'])&&$data['limit']) ? $data['limit'] : 15;
        $taskIDs = WorkModel::where('uid',$this->uid)->select('task_id')->distinct()->get()->toArray();
        if(count($taskIDs)){
            $tasks = TaskModel::whereIn('id',$taskIDs);
            if (isset($data['status']) && $data['status']){
                switch($data['status']){
                    case 1:
                        $status = [3,4,6];
                        break;
                    case 2:
                        $status = [5];
                        break;
                    case 3:
                        $status = [7];
                        break;
                    case 4:
                        $status = [8,9,10];
                        break;
                    default:
                        $status = [2,3,4,5,6,7,8,9,10,11];
                }
                $tasks = $tasks->whereIn('task.status',$status);
            }

            $tasks = $tasks->where('task.status','>=',2)->where('task.status','<=',11)->orderBy('task.created_at','desc')->paginate($data['limit'])->toArray();
            $status = [
                2=>'审核中',
                3=>'定时发布',
                4=>'投稿中',
                5=>'选稿中',
                6=>'选稿中',
                7=>'交付中',
                8=>'待评价',
                9=>'已结束',
                10=>'已结束',
                11=>'维权中'
            ];
            if(isset($data['status'])){
                $tasks['workStatus'] = $data['status'];
            } else{
                $tasks['workStatus'] = 0;
            }
            foreach($tasks['data'] as $k=>$v){
                $tasks['data'][$k]['status'] = $status[$v['status']];
            }
        }else{
            $tasks = [];
        }
        return $this->formateResponse(1000,'success',$tasks);
    }


    
    public function createTask(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => 'required',
            'desc' => 'required',
            'cate_id' => 'required',
            'bounty' => 'required|numeric',
            'worker_num' => 'required|integer|min:1',
            'province' => 'required',
            'city' => 'required',
            'delivery_deadline' => 'required',
            'begin_at' => 'required',
            'phone' => 'required'
        ],[
            'title.required' => '请填写任务标题',
            'desc.required' => '请填写任务描述',
            'cate_id.required' => '请选择行业类型',
            'bounty.required' => '请输入您的预算',
            'bounty.numeric' => '请输入正确的预算格式',
            'worker_num.required' => '中标人数不能为空',
            'worker_num.integer' => '中标人数必须为整形',
            'worker_num.min' => '中标人数最少为1人',

            'province.required' => '请选择省份',
            'city.required' => '请选择城市',
            'delivery_deadline.required' => '请选择投稿截止时间',
            'begin_at.required' => '请选择任务开始时间',
            'phone.required' => '请输入手机号'
        ]);

        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formateResponse(2001,'输入的信息有误', $error);
        }
        if(strtotime($data['begin_at']) < time()){
            if($data['begin_at'] == date('Y-m-d',time())){
                $data['begin_at'] = date('Y-m-d H:i:s');
            }
            else{
                return $this->formateResponse(2003,'任务开始时间不得小于当前时间');
            }
        }
        if(strtotime($data['delivery_deadline']) <= strtotime($data['begin_at'])){
            return $this->formateResponse(2004,'截稿时间必须大于发布时间一天');
        }
        $taskTypeInfo = TaskTypeModel::where('alias','xuanshang')->select('id')->first();
        $arrTaskInfo = array(
            'uid' => $this->uid,
            'title' => $data['title'],
            'desc' => $data['desc'],
            'cate_id' => $data['cate_id'],
            'bounty' => $data['bounty'],
            'show_cash' => $data['bounty'],
            'worker_num' => $data['worker_num'],
            'province' => $data['province'],
            'city' => $data['city'],
            'delivery_deadline' => $data['delivery_deadline'],
            'status' => 0,
            'begin_at' => $data['begin_at'],
            'type_id' => $taskTypeInfo->id,
            'phone' => $data['phone']
        );
        $file_id = $request->get('file_id');
        $result = DB::transaction(function() use ($arrTaskInfo,$file_id){
            $task = TaskModel::create($arrTaskInfo);
            if(!empty($file_id)){
                
                $file_able_ids = AttachmentModel::fileAble($file_id);
                $file_able_ids = array_flatten($file_able_ids);

                foreach($file_able_ids as $v){
                    $attachment_data = [
                        'task_id'=>$task['id'],
                        'attachment_id'=>$v,
                        'created_at'=>date('Y-m-d H:i:s', time()),
                    ];
                    TaskAttachmentModel::create($attachment_data);
                }
                
                $attachmentModel = new AttachmentModel();
                $attachmentModel->statusChange($file_able_ids);
            }

            $taskInfo = TaskModel::findById($task['id']);

            return $taskInfo;
        });
        if($result){
            return $this->formateResponse(1000,'success',$result);
        }else{
            return $this->formateResponse(2002,'创建失败');
        }
    }

    
    public function createWinBidWork(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'desc' => 'required|str_length:2048'
        ],[
            'desc.required' => '请输入稿件描述',
            'desc.str_length'=> '字数超过限制',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formateResponse(2001,'参数有误', $error);
        }

        
        $data['status'] = 0;
        $result = $this->isWorkAble($data['task_id']);
        if($result['status'] == 0){
            return $this->formateResponse(2002,$result['message']);
        }

        $data['uid'] = $this->uid;
        $data['desc'] = e($data['desc']);
        $data['created_at'] = date('Y-m-d H:i:s');

        $workModel = new WorkModel();
        $result = $workModel->workCreate($data);
        if(!$result){
            return $this->formateResponse(2003,'投稿失败');
        }

        return $this->formateResponse(1000,'success');
    }

    
    public function createDeliveryWork(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'desc' => 'required|str_length:2048'
        ],[
            'desc.required' => '请输入稿件描述',
            'desc.str_length'=> '字数超过限制',
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formateResponse(2001,'参数有误', $error);
        }

        
        $able = WorkModel::isWinBid($data['task_id'],$this->uid);
        if(!$able){
            return $this->formateResponse(2001,'你的稿件没有中标不能通过交付');
        }
        
        $is_delivery = WorkModel::where('task_id',$data['task_id'])
            ->where('uid',$this->uid)
            ->where('status','>=',2)->first();
        if($is_delivery){
            return $this->formateResponse(2003,'你已交付过稿件');
        }

        $data['uid'] = $this->uid;
        $data['status'] = 2;
        $data['created_at'] = date('Y-m-d H:i:s',time());

        $result = WorkModel::delivery($data);

        if($result){
            return $this->formateResponse(1000,'success');
        }else{
            return $this->formateResponse(2004,'交付失败');
        }
    }



    
    public function applauseRate(Request $request)
    {
        $applauseRate = \CommonClass::applauseRate($request->get('uid'));
        $data = array(
            'applauseRate' => $applauseRate,
        );
        return $this->formateResponse(1000,'success',$data);
    }


    
    public function workWinBid(Request $request)
    {
        $id = $request->get('id');
        $work = WorkModel::where('id',$id)->first();
        if(!$work){
            return $this->formateResponse(2001,'未找到对应的稿件信息');
        }

        
        $task = TaskModel::where('id',$work->task_id)->first();
        $work_num = WorkModel::where('task_id',$work->task_id)->where('status',1)->count();
        if($this->uid != $task->uid){
            return $this->formateResponse(2002,'你不是任务发布者，无权操作！');
        }
        if($task->worker_num > $work_num){
            $data = array(
                'task_id' => $work->task_id,
                'work_id' => $id,
                'worker_num' => $task->worker_num,
                'win_bid_num' => $work_num
            );
            $work_model = new WorkModel();
            $result = $work_model->winBid($data);
            if($result){
                return $this->formateResponse(1000,'success');
            }else{
                return $this->formateResponse(2001,'稿件状态修改失败');
            }
        }else{
            return $this->formateResponse(2003,'当前中标人数已满');
        }

    }

    
    public function deliveryWorkAgree(Request $request)
    {
        $data = $request->all();
        $work_id = intval($data['work_id']);
        $work = WorkModel::where('id',$work_id)->first();
        if(!$work){
            return $this->formateResponse(2003,'此稿件不存在');
        }
        $task = TaskModel::where('id',$work->task_id)->first();

        
        if($task->uid != $this->uid){
            return $this->formateResponse(2001,'你不是雇主，无权操作');
        }

        $work = WorkModel::where('task_id',$work->task_id)->where('uid',$work->uid)->where('status',2)->first();
        
        if($work->status != 2){
            return $this->formateResponse(2002,'当前稿件不具备验收资格');
        }
        
        $worker_num = $task->worker_num;
        
        $win_check = WorkModel::where('task_id',$work->task_id)->where('status','>',3)->count();

        $data['worker_num'] = $worker_num;
        $data['win_check'] = $win_check;
        $data['task_id'] = $work->task_id;
        $data['uid'] = $this->uid;
        $data['work_id'] = $work->id;

        $workModel = new WorkModel();
        $result = $workModel->workCheck($data);
        if($result){
            return $this->formateResponse(1000,'success');
        }else{
            return $this->formateResponse(2004,'failure');
        }
    }

    
    public function deliveryWorkRight(Request $request)
    {
        if(!$request->get('work_id') or !$request->get('desc')){
            return $this->formateResponse(2003,'传送参数不能为空');
        }
        $data = $request->all();
        $work_id = intval($data['work_id']);
        $work = WorkModel::where('id',$work_id)->first();
        $task = TaskModel::where('id',$work->task_id)->first();

        
        if(($work->uid != $this->uid) && ($task->uid != $this->uid)){
            return $this->formateResponse(2001,'你不具备维权资格');
        }

        
        if($work->uid == $this->uid){
            $data['role'] = 0;
            $data['from_uid'] = $this->uid;
            $data['to_uid'] = $task->uid;
        }
        if($task->uid == $this->uid){
            $data['role'] = 1;
            $data['from_uid'] = $this->uid;
            $data['to_uid'] = $work->uid;
        }
        $data['status'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s',time());

        $result = TaskRightsModel::rightCreate($data);
        if($result){
            return $this->formateResponse(1000,'success');
        }else{
            return $this->formateResponse(2002,'维权失败');
        }
    }

    
    public function commentCreate(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'comment'=>'required',
            'task_id'=>'required',
            'work_id'=>'required',
        ],[
            'comment.required' => '回复内容不能为空',
            'task_id.required' => '所属任务id不能为空',
            'work_id.required' => '所属稿件id不能为空'
        ]);
        $error = $validator->errors()->all();
        if(count($error)){
            return $this->formateResponse(2001,'稿件评论参数不全', $error);
        }
        $data['comment'] = e($data['comment']);
        $data['uid'] = $this->uid;
        $userDetail = UserDetailModel::where('uid',$this->uid)->first();
        $data['nickname'] = $userDetail->nickname;
        $data['created_at'] = date('Y-m-d H:i:s');

        $workComment = WorkCommentModel::create($data);
        $result = WorkCommentModel::where('id',$workComment)->first();
        if($result){
            $result->avatar = $userDetail->avatar;
            return $this->formateResponse(1000,'success',$result);
        }else{
            return $this->formateResponse(2001,'回复失败');
        }
    }

    
    public function evaluateCreate(Request $request)
    {
        $data = $request->all();
        
        $work = WorkModel::where('task_id',$data['task_id'])
            ->where('uid',$this->uid)
            ->where('status',3)
            ->first();
        $task = TaskModel::where('id',$data['task_id'])->first();
        if(!$work && $task->uid != $this->uid){
            return $this->formateResponse(2001,'你没有评价此稿件的权限');
        }
        
        $data['from_uid'] = $this->uid;
        $data['comment'] = e($data['comment']);

        if($work)
        {
            $data['to_uid'] = $task->uid;
            $data['comment_by'] = 0;
        }
        if($task->uid == $this->uid)
        {
            $work = WorkModel::where('id',$data['work_id'])->first();
            $data['to_uid'] = $work['uid'];
            $data['comment_by'] = 1;
        }

        $is_evaluate =  CommentModel::where('from_uid',$this->uid)
            ->where('task_id',$data['task_id'])->where('to_uid',$data['to_uid'])
            ->first();
        if($is_evaluate){
            return $this->formateResponse(2002,'你已评论过此稿件');
        }
        $data['created_at'] = date('Y-m-d H:i:s',time());

        $comment = CommentModel::create($data);
        $result = CommentModel::where('id',$comment['id'])->first();
        if($comment){
            return $this->formateResponse(1000,'success',$result);
        }else{
            return $this->formateResponse(2003,'评论失败');
        }
    }

    
    public function getEvaluate(Request $request)
    {
        $work_id = $request->get('work_id');
        $work = WorkModel::where('id',$work_id)->where('status',3)->first();
        if(!$work){
            return $this->formateResponse(2002,'稿件交易未完成，暂无评价信息');
        }
        $task = TaskModel::where('id',$work->task_id)->first();
        
        if(($this->uid != $work->uid) && ($this->uid != $task->uid)){
            return $this->formateResponse(2002,'你没有查看该稿件评价信息的权限');
        }
        if($this->uid == $work->uid){
            $evaluate = CommentModel::where('task_id',$task->id)->where('from_uid',$task->uid)->first();
        }
        if($this->uid == $task->uid){
            $evaluate = CommentModel::where('task_id',$task->id)->where('from_uid',$work->uid)->first();
        }
        if($evaluate){
            return $this->formateResponse(1000,'success',$evaluate);
        }else{
            return $this->formateResponse(2001,'暂无相关评价信息');
        }
    }

    
    public function isWorkAble($task_id)
    {
        $data = array(
            'status' => 1,
            'message' => '',
        );
        if(!$this->uid){
            $data['status'] = 0;
            $data['message'] = '请先登录';
        }
        $task = TaskModel::where('id',$task_id)->first();
        if($task){
            
            if($task->uid == $this->uid){
                $data['status'] = 0;
                $data['message'] = '你是任务发布者，无法投稿';
            }
            
            $work = WorkModel::where('task_id',$task_id)->where('uid',$this->uid)->first();
            if($work){
                $data['status'] = 0;
                $data['message'] = '你已投稿或中标';
            }
        }else{
            $data['status'] = 0;
            $data['message'] = '任务不存在，无法投稿';
        }

        return $data;
    }

    
    public function fileUpload(Request $request)
    {
        $file = $request->file('file');
        
        $attachment = \FileClass::uploadFile($file,'task');
        $attachment = json_decode($attachment, true);
        
        if($attachment['code']!=200)
        {
            return $this->formateResponse(2001,$attachment['message']);
        }
        $attachment_data = array_add($attachment['data'], 'status', 1);
        $attachment_data['created_at'] = date('Y-m-d H:i:s', time());
        
        $result = AttachmentModel::create($attachment_data);
        $data = AttachmentModel::where('id',$result['id'])->first();
        $domain = ConfigModel::where('alias','site_url')->where('type','site')->select('rule')->first();
        if(isset($data)){
            $data->url = $data->url?$domain->rule.'/'.$data->url:$data->url;
        }
        if($result){
            return $this->formateResponse(1000,'success',$data);
        }else{
            return $this->formateResponse(2002,'文件上传失败');
        }
    }

    
    public function fileDelete(Request $request)
    {
        $id = $request->get('id');
        $result = AttachmentModel::del($id,$this->uid);
        if($result){
            return $this->formateResponse(1000,'success');
        }else{
            return $this->formateResponse(2001,'附件删除失败');
        }
    }


    
    public function noPubTask(Request $request){
        $tasks = TaskModel::whereIn('task.status',[0,1])
            ->where('task.uid',$this->uid)
            ->select('task.*','cate.name as cate_name')
            ->leftjoin('cate','task.cate_id','=','cate.id')
            ->orderBy('task.created_at','desc')
            ->paginate()->toArray();
        return $this->formateResponse(1000,'success',$tasks);
    }


    
    public function agreeDelivery(Request $request){
        if(!$request->get('task_id') or !$request->get('id')){
            return $this->formateResponse(1060,'传送参数不能为空');
        }
        $deliveryInfo = [];
        $userInfo = UserModel::select('users.name')
            ->leftjoin('task','users.id','=','task.uid')
            ->where('task.id',intval($request->get('task_id')))
            ->where('task.uid',intval($this->uid))
            ->first();
        if(!isset($userInfo)){
            return $this->formateResponse(1061,'传送任务id错误');
        }
        $deliveryInfo['gname'] = $userInfo->name;
        $serverInfo = UserModel::select('users.name','work.id','work.desc')
            ->leftjoin('work','users.id','=','work.uid')
            ->where('work.uid',intval($request->get('id')))
            ->where('work.task_id',intval($request->get('task_id')))
            ->where('work.status','>=','2')
            ->first();
        if(!isset($serverInfo)){
            return $this->formateResponse(1062,'传送威客id错误');
        }
        $deliveryInfo['wname'] = $serverInfo->name;
        $deliveryInfo['desc'] = $serverInfo->desc;
        $attachIds = WorkAttachmentModel::where('task_id',intval($request->get('task_id')))
            ->where('work_id',$serverInfo->id)
            ->select('attachment_id')
            ->get()
            ->toArray();
        $attachInfo = [];
        if(isset($attachIds)){
            $attachIds = array_flatten($attachIds);
            $attachInfo = AttachmentModel::whereIn('id',$attachIds)
                ->select('url')
                ->get()
                ->toArray();
            $attachInfo = array_flatten($attachInfo);
            $domain = ConfigModel::where('alias','site_url')->where('type','site')->select('rule')->first();
            foreach($attachInfo as $k=>$v){
                $attachInfo[$k] = $attachInfo[$k]?$domain->rule.'/'.$attachInfo[$k]:$attachInfo[$k];
            }
        }
        $deliveryInfo['attachInfo'] = $attachInfo;
        return $this->formateResponse(1000,'获取协议信息成功',$deliveryInfo);

    }


    
    public function guestDelivery(Request $request){
        if(!$request->get('task_id')){
            return $this->formateResponse(1060,'传送参数不能为空');
        }
        $deliveryInfo = [];
        $userInfo = UserModel::select('users.name')
            ->leftjoin('task','users.id','=','task.uid')
            ->where('task.id',intval($request->get('task_id')))
            ->first();
        if(!isset($userInfo)){
            return $this->formateResponse(1061,'传送任务id错误');
        }
        $deliveryInfo['gname'] = $userInfo->name;
        $serverInfo = UserModel::select('users.name','work.id','work.desc')
            ->leftjoin('work','users.id','=','work.uid')
            ->where('work.uid',intval($this->uid))
            ->where('work.task_id',intval($request->get('task_id')))
            ->where('work.status','>=','2')
            ->first();
        if(!isset($serverInfo)){
            return $this->formateResponse(1062,'传送威客id错误');
        }
        $deliveryInfo['wname'] = $serverInfo->name;
        $deliveryInfo['desc'] = $serverInfo->desc;
        $attachIds = WorkAttachmentModel::where('task_id',intval($request->get('task_id')))
            ->where('work_id',$serverInfo->id)
            ->select('attachment_id')
            ->get()
            ->toArray();
        $attachInfo = [];
        if(isset($attachIds)){
            $attachIds = array_flatten($attachIds);
            $attachInfo = AttachmentModel::whereIn('id',$attachIds)
                ->select('url')
                ->get()
                ->toArray();
            $attachInfo = array_flatten($attachInfo);
            $domain = ConfigModel::where('alias','site_url')->where('type','site')->select('rule')->first();
            foreach($attachInfo as $k=>$v){
                $attachInfo[$k] = $attachInfo[$k]?$domain->rule.'/'.$attachInfo[$k]:$attachInfo[$k];
            }
        }
        $deliveryInfo['attachInfo'] = $attachInfo;
        return $this->formateResponse(1000,'获取协议信息成功',$deliveryInfo);
    }



}