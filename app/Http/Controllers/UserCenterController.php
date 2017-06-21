<?php

namespace App\Http\Controllers;

use App\Modules\Manage\Model\ArticleCategoryModel;
use App\Modules\Manage\Model\ConfigModel;
use App\Modules\Task\Model\TaskCateModel;
use App\Modules\User\Model\MessageReceiveModel;
use App\Modules\User\Model\UserDetailModel;
use App\Modules\User\Model\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserCenterController extends BasicController
{

    public function __construct()
    {
        parent::__construct();

        //网站关闭
        $siteConfig = ConfigModel::getConfigByType('site');
        if ($siteConfig['site_close'] == 2){
            abort('404');
        }

        //前端头部
        if (Auth::check()){
            $user = Auth::User();

            $userDetail = UserDetailModel::select('alternate_tips','avatar')->where('uid', $user->id)->first();
            $this->theme->set('username', $user->name);
            $this->theme->set('tips', empty($userDetail)?'':$userDetail->alternate_tips); // 支付提示， 默认支持
            $this->theme->set('avatar',empty($userDetail)?'':$userDetail->avatar); // 头像

            //查询未读消息
            /**
             * CREATE TABLE `kppw_message_receive` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `code_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '模板别名',
            `message_title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '标题',
            `message_content` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '消息内容',
            `js_id` int(11) DEFAULT NULL COMMENT '接收人id',
            `fs_id` int(11) DEFAULT NULL COMMENT '发送人id',
            `message_type` tinyint(4) DEFAULT NULL COMMENT '消息类型 1=>系统消息 2=>交易动态 3=>站内信',
            `receive_time` timestamp NULL DEFAULT NULL COMMENT '收信时间',
            `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 1=>已读 0=>未读',
            `read_time` timestamp NULL DEFAULT NULL COMMENT '读取时间',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
             * */
            $systemMessage =  MessageReceiveModel::where('js_id', $user->id)->where('message_type',1)->where('status',0)->count();
            $tradeMessage =  MessageReceiveModel::where('js_id',$user->id)->where('message_type',2)->where('status',0)->count();
            $receiveMessage =  MessageReceiveModel::where('js_id',$user->id)->where('message_type',3)->where('status',0)->count();
            $this->theme->set('system_message_count',$systemMessage);
            $this->theme->set('trade_message_count',$tradeMessage);
            $this->theme->set('receive_message_count',$receiveMessage);
        }

        //前端底部公共页脚配置
        $parentCate = ArticleCategoryModel::select('id')->where('cate_name','页脚配置')->first();
        if(!empty($parentCate)){
            $articleCate = ArticleCategoryModel::where('pid',$parentCate->id)->limit(4)->get()->toArray();
            $this->theme->set('article_cate', $articleCate);
        }

        //判断是否开启IM (1=>开启)
        $basisConfig = ConfigModel::getConfigByType('basis');
        if(!empty($basisConfig)){
            $this->theme->set('basis_config',$basisConfig);
        }
        if(!empty($basisConfig) && $basisConfig['open_IM'] == 2){
            $ImPath = app_path('Modules' . DIRECTORY_SEPARATOR . 'Im');
            //判断是否有Im目录
            if(is_dir($ImPath)){
                $contact = 1;
                if (Auth::check()){
                    $arrFriendUid = \App\Modules\Im\Model\ImAttentionModel::where('uid', $user->id)->lists('friend_uid')->toArray();
                    $arrAttention = UserModel::select('users.id', 'users.name', 'user_detail.avatar', 'user_detail.autograph')->whereIn('users.id', $arrFriendUid)
                        ->leftJoin('user_detail', 'users.id', '=', 'user_detail.uid')->get()->toArray();
                    $this->theme->set('attention', $arrAttention);
                }
            }else{
                $contact = 2;
            }
        }else{
            $contact = 2;
        }
        $this->theme->set('is_IM_open',$contact);
    }


}
