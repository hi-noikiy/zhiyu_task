<?php

namespace App\Modules\Task\Model;

use App\Modules\Manage\Model\MessageTemplateModel;
use App\Modules\User\Model\AttachmentModel;
use App\Modules\User\Model\MessageReceiveModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use App\RemoteApiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;




class WorkModel extends Model
{
    protected $table = 'work';
    public  $timestamps = false;  
    public $fillable = ['desc','task_id','status','uid','bid_at', 'user_name', 'avatar', 'created_at'];

    
    public function childrenAttachment()
    {
        return $this->hasMany('App\Modules\Task\Model\WorkAttachmentModel', 'work_id', 'id');
    }

    
    public function childrenComment()
    {
        return $this->hasMany('App\Modules\Task\Model\WorkCommentModel', 'work_id', 'id');
    }
    
    static function isWorker($uid,$task_id)
    {
        $query = Self::where('uid','=',$uid);
        $query = $query->where(function($query) use($task_id){
            $query->where('task_id',$task_id);
        });
        $result = $query->first();
        if($result) return true;

        return false;
    }

    
    static function isWinBid($task_id,$uid)
    {
        $query = Self::where('task_id',$task_id)->where('status',1)->where('uid',$uid);

        $result = $query->first();

        if($result) return $result['status'];

        return false;
    }

    
    static function findAll($id,$data=array())
    {
        $query = Self::select('work.*')
            ->where('work.task_id',$id)->where('work.status','<=',1)->where('forbidden',0);
        if(isset($data['work_type'])){
            switch($data['work_type'])
            {
                case 1:
                    $query->where('work.status','=',0);
                    break;
                case 2:
                    $query->where('work.status','=',1);
                    break;
            }
        }
        $data = $query->with('childrenAttachment')
            ->with('childrenComment')
            ->paginate(5)->setPageName('work_page')->toArray();
        return $data;
    }

    
    static function countWorker($task_id,$status)
    {
        $query = Self::where('status',$status);
        $data = $query->where(function($query) use($task_id){
            $query->where('task_id',$task_id);
        })->count();

        return $data;
    }

    
    public function workCreate($data)
    {
        $status = DB::transaction(function() use($data){
            
            $result = WorkModel::create($data);

            if(isset($data['file_id'])){
                $file_able_ids = AttachmentModel::select('attachment.id','attachment.type')->whereIn('id',$data['file_id'])->get()->toArray();
                
                foreach($file_able_ids as $v){
                    $work_attachment = [
                        'task_id'=>$data['task_id'],
                        'work_id'=>$result['id'],
                        'attachment_id'=>$v['id'],
                        'type'=>$v['type'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    WorkAttachmentModel::create($work_attachment);
                }
            }
            
            UserDetailModel::where('uid',$data['uid'])->increment('receive_task_num',1);
            
            TaskModel::where('id',$data['task_id'])->increment('delivery_count',1);
            
            $work = WorkModel::where('task_id',$data['task_id'])->count();
            if($work==1)
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>4]);
            }
        });

        return is_null($status)?true:false;
    }

    /**
     * 流程：
     * @param array $data [任务id，投稿id，任务需求数量，投稿中标数量]
     * 修改当前投稿人的投稿状态为中标状态
     * 如果任务需求量 等于 中标数量，若有公示期，进入公示期或交付验收期
     * 发送模板消息
     *
     * @return bool
     * */
    public function winBid($data)
    {
        $status = DB::transaction(function() use($data){
            
            Self::where('id',$data['work_id'])->update(['status'=>1]);

            /*
            TaskModel::where('id', $data['task_id'])
                ->update(['status'=>7,'publicity_at'=>date('Y-m-d H:i:s',time()),'checked_at'=>date('Y-m-d H:i:s',time())]);

            if(($data['win_bid_num']+1) == $data['worker_num'])
            {
                $task_publicity_day = \CommonClass::getConfig('task_publicity_day');
                if($task_publicity_day==0)
                {
                    TaskModel::where('id',$data['task_id'])
                        ->update(['status'=>7,'publicity_at'=>date('Y-m-d H:i:s',time()),'checked_at'=>date('Y-m-d H:i:s',time())]);
                }else{
                    TaskModel::where('id',$data['task_id'])->update(['status'=>6,'publicity_at'=>date('Y-m-d H:i:s',time())]);
                }
            }
            */
        });
        
        if(is_null($status))
        {
            $task_win = MessageTemplateModel::where('code_name','task_win')->where('is_open',1)->where('is_on_site',1)->first();
            if($task_win)
            {
                $task = TaskModel::where('id',$data['task_id'])->first();
                $work = WorkModel::where('id',$data['work_id'])->first();
                //$user = UserModel::where('id',$work['uid'])->first();


                $site_name = \CommonClass::getConfig('site_name');
                
                $messageVariableArr = [
                    'username'=>$work['user_name'],
                    'website'=>$site_name,
                    'task_number'=>$task['id'],
                    'task_title'=>$task['title'],
                    'win_price'=>$task['bounty'], // 总金额平分中标人数
                ];
                $message = MessageTemplateModel::sendMessage('task_win',$messageVariableArr);
                $data = [
                    'message_title'=>'任务中标通知',
                    'message_content'=>$message,
                    'js_id'=>$work['uid'],
                    'message_type'=>2,
                    'receive_time'=>date('Y-m-d H:i:s',time()),
                    'status'=>0,
                ];
                MessageReceiveModel::create($data);


                /**
                 * 远程任务接口
                 * */
                $remoteData = array(
                    'task_id'    => $task['id'],
                    'task_name'  => $task['title'],
                    'task_money' => $task['bounty'] * 100,
                    'uid'        => $work['uid']
                );

                RemoteApiModel::taskSystemtaskSystemRemote($remoteData);
            }
        }

        return is_null($status) ? true : false;
    }

    
    static public function findDelivery($id,$data)
    {
        $query = Self::select('work.*')
            ->where('work.task_id',$id)->where('work.status','>=',2);
        
        if(isset($data['evaluate'])){
            switch($data['evaluate'])
            {
                case 1:
                    $query->where('status','>=',0);
                    break;
                case 2:
                    $query->where('status','>=',1);
                    break;
                case 3:
                    $query->where('status','>=',2);
            }
        }
        $data = $query->with('childrenAttachment')
            ->paginate(5)->setPageName('delivery_page')->toArray();
        return $data;
    }

    
    static public function findRights($id)
    {
        $data = Self::select('work.*')
            ->where('task_id',$id)->where('work.status',4)
            ->with('childrenAttachment')
            ->paginate(5)->setPageName('delivery_page')->toArray();
        return $data;
    }
    
    static public function delivery($data)
    {
        $status = DB::transaction(function() use($data){
            
            $result = WorkModel::create($data);

            if(isset($data['file_id'])){
                $file_able_ids = AttachmentModel::select('attachment.id','attachment.type')->whereIn('id',$data['file_id'])->get()->toArray();
                
                foreach($file_able_ids as $v){
                    $work_attachment = [
                        'task_id'=>$data['task_id'],
                        'work_id'=>$result['id'],
                        'attachment_id'=>$v['id'],
                        'type'=>$v['type'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    WorkAttachmentModel::create($work_attachment);
                }
            }





        });

        return is_null($status)?true:false;
    }

    
    static public function workCheck($data)
    {
        $status = DB::transaction(function() use($data) {
            
            Self::where('id', $data['work_id'])->update(['status' => 3, 'bid_at' => date('Y-m-d H:i:s', time())]);
            
            TaskModel::distributeBounty($data['task_id'],$data['uid']);

            
            if(($data['win_check']+1)==$data['worker_num'])
            {
                TaskModel::where('id',$data['task_id'])->update(['status'=>8,'comment_at'=>date('Y-m-d H:i:s',time())]);
            }
        });
        
        if(is_null($status))
        {
            
            $manuscript_settlement = MessageTemplateModel::where('code_name','manuscript_settlement')->where('is_open',1)->where('is_on_site',1)->first();
            if($manuscript_settlement)
            {
                $task = TaskModel::where('id',$data['task_id'])->first();
                $work = WorkModel::where('id',$data['work_id'])->first();
                $user = UserModel::where('id',$work['uid'])->first();
                $site_name = \CommonClass::getConfig('site_name');
                $domain = \CommonClass::getDomain();
                
                
                $messageVariableArr = [
                    'username'=>$user['name'],
                    'task_number'=>$task['id'],
                    'task_link'=>$domain.'/task/'.$task['id'],
                    'website'=>$site_name,
                ];
                $message = MessageTemplateModel::sendMessage('manuscript_settlement',$messageVariableArr);
                $data = [
                    'message_title'=>'任务验收通知',
                    'message_content'=>$message,
                    'js_id'=>$user['id'],
                    'message_type'=>2,
                    'receive_time'=>date('Y-m-d H:i:s',time()),
                    'status'=>0,
                ];
                MessageReceiveModel::create($data);
            }
        }
        return is_null($status)?true:false;
    }


}
