<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemoteApiModel extends Model
{
    private $_debug = false;
    private $_method;
    private $_url;
    private $_charset = 'utf-8';

    static public $status = '';
    static public $timeout = 10;

    private $_remoteUrl = "http://api.yjob.net";
    private $_remoteType = array(
        'post' => array(
            'jobClose' 				=> '/job/close',
            'jobDelete' 			=> '/job/delete',
            'jobRefresh' 			=> '/job/refresh',
            'jobCreate' 			=> '/job/create',
            'jobConfirm' 			=> '/job/confirm',
            'jobRvaluate' 			=> '/job/evaluate',
            'jobUpdate' 			=> '/job/update',
            'jobPast' 				=> '/job/past',
            'jobList' 				=> '/job/list',
            'jobAudit' 				=> '/job/audit',
            'jobSearch' 			=> '/job/search',
            'jobFavJob' 			=> '/job/favJob',
            'jobFavJobList' 		=> '/job/favJobList',
            'jobPastList' 			=> '/job/pastList',
            'jobAutoRefresh' 		=> '/job/autoRefresh',
            'jobFobStatistics' 		=> '/job/jobStatistics',
            'jobEvaluateInfo' 		=> '/job/evaluateInfo',
            /*
             * Enroll 配置区
             * */
            'enrollIsEnroll'   		=> '/enroll/isEnroll',
            'enrollUpdate'  		=> '/enroll/update',
            'enrollStood'  			=> '/enroll/stood',
            'enrollLeaveEarly'  	=> '/enroll/leaveEarly',
            'enrollStatus'  		=> '/enroll/status',
            'enrollAdd'  			=> '/enroll/add',
            'enrollEnrollCount' 	=> '/enroll/enrollCount',
            'enrollInfo'  			=> '/enroll/info',
            'enrollList'  			=> '/enroll/list',
            /*
             * User 配置区
             * */
            'userAuthUser'  		=> '/user/authUser',
            'userUpdateIntention'  	=> '/user/updateIntention',
            'userRegister'  		=> '/user/register',
            'userAddIntention'  	=> '/user/addIntention',
            'userAddResume'  		=> '/user/addResume',
            'userLogin'  			=> '/user/login',
            'userThirdParty'  		=> '/user/thirdParty',
            'userResumeList'  		=> '/user/resumeList',
            'userReputation'  		=> '/user/reputation',
            'userIntentionInfo'  	=> '/user/intentionInfo',
            'userResumeInfo'  		=> '/user/resumeInfo',
            'userAuthUserList'  	=> '/user/authUserList',
            'userAuthVerify' 		=> '/user/authVerify',
            'userResetPassWd' 		=> '/user/resetPassWd',
            'userUpdate'			=> '/user/update',
            'userInfo'				=> '/user/info',
            'userAdd'				=> '/user/add',
            'userCheckInviteCodeExist'	=> '/user/checkInviteCodeExist',
            'userInviteList'		=> '/user/inviteList',
            /*
             * 关注、取消公众号
             * */
            'userSubscribe'			=> '/user/subscribe',
            'userUnsubscribe'		=> '/user/unsubscribe',
            /*
             * Sms 配置区
             * */
            'smsSend'				=> '/sms/sendCode',
            'smsCheck'				=> '/sms/checkCode',
            /*
             * redEnvelope 配置区
             * */
            'redEnvelopeEdit'		=> '/redEnvelope/edit',
            'redEnvelopeCreate'		=> '/redEnvelope/create',
            'redEnvelopeDelete'		=> '/redEnvelope/delete',
            'redEnvelopeLootQueue'	=> '/redEnvelope/lootQueue',
            'redEnvelopeCheckStatus'=> '/redEnvelope/checkStatus',
            'redEnvelopeList'		=> '/redEnvelope/list',
            'redEnvelopeStop'		=> '/redEnvelope/stop',
            'redEnvelopeInfo'		=> '/redEnvelope/info',
            'redEnvelopeTakeInfo'	=> '/redEnvelope/takeInfo',
            /*
             * 获取微信公众号access_token
             * */
            'weixinWxAccessToken'	=> '/weixin/wxAccessToken',
            /*
             * /payment/withdraw 红包提现
             * */
            'paymentWithdraw'		=> '/payment/withdraw',
            'paymentWithdrawList'	=> '/payment/withdrawList',
            /*
             * Task 任务系统部分
             * */
            'taskSystemTakeInfo' => '/taskSystem/takeInfo',
            'taskSystemGetNewRedPack' => '/taskSystem/getNewRedPack',
            'taskSystemGetNewRedPackInfo' => '/taskSystem/getNewRedPackInfo',
        ),
        'get' => array(
            'jobInfo' 				=> '/job/info'
        )
    );

    private function arr_merge($functionName){
        foreach($this->_remoteType as $aK => $aV){
            foreach($aV as $funcK => $funcV){
                if(strtolower($functionName) == strtolower($funcK)){
                    $this->_method = $aK;
                    $this->_url = $this->_remoteUrl . $funcV;
                    break;
                }
            }
        }
        if(!$this->_method) dd('没有此方法！');
    }

    public static function __callStatic($functionName, $params)
    {
        $RemoteApiModelObj = new RemoteApiModel();
        $RemoteApiModelObj->arr_merge($functionName);
        if(count($params) > 1){
            dd('暂只支持 1 个数组的参数');
        }
        return $RemoteApiModelObj->send($params[0]);
    }
    /**
     * 发送请求并返回数据
     *
     * @param array $arguments 请求的数据
     * @param array|string $clientInfo 接口信息或接口名
     * @return string 返回接口返回的数据
     * @return $this_header 请求URL的header头
     */
    private function send($arguments, $this_header = null) {
        if(!$this_header){
            $tTime = time();
            $arguments = ['jsonData' => json_encode($arguments)];
            $arguments = is_array($arguments) ? http_build_query($arguments, '', '&') : $arguments;
            $this_header = array("API-ID:100001",
                "API-TIME:" . $tTime,
                "API-HASH:" . hash_hmac('sha256', $tTime . 100001 . $arguments, "593fe6ed77014f9507761028801aa376f141916bd26b1b3f0271b5ec3135b989")
            );
        }

        $returnValue = false;

        if($this->_url && $this->_method && $this->_charset){
            $requestUrl = $this->_url;
            //post get 分别处理
            if(strtolower($this->_method) == 'get'){
                //请求的URL处理，如果是GET，需要将参数变成get字串拼进URL
                $concatChar = '?';
                if (strpos($requestUrl,'?')) {
                    $concatChar = '&';
                }
                if(is_array($arguments)){
                    $arguments = http_build_query($arguments);
                    $requestUrl = $requestUrl . $concatChar . $arguments;
                    $returnValue = self::get($requestUrl, $this->_charset, $this_header);
                }elseif(is_numeric($arguments)){
                    $requestUrl = $requestUrl . '/' . $arguments;
                    $returnValue = self::get($requestUrl, $this->_charset, $this_header);
                }else{
                    $requestUrl = $requestUrl . $concatChar . $arguments;
                    $returnValue = self::get($requestUrl, $this->_charset, $this_header);
                }
            }else{

                $returnValue = self::post($requestUrl, $arguments, $this->_charset, $this_header);
            }
        }
        if($this->_debug){
            $endTime = $this->_getmicrotime();
            $costTime = $endTime - $startTime;
            $requestInfo['api_name'] = $this->_apiName;
            $requestInfo['api_url'] = $this->_url;
            $requestInfo['request_method'] = $this->_method;
            $requestInfo['request_data'] = $arguments;
            $requestInfo['charset'] = $this->_charset;
            $requestInfo['request_time'] = date("Y-m-d H:i:s", $startTime);
            $requestInfo['response_time'] = date("Y-m-d H:i:s", $endTime);
            $requestInfo['use_time'] = $costTime;
            $requestInfo['response_data'] = json_decode($returnValue, true);
            $requestInfo['response_code'] = self :: $status;
        }
        return json_decode($returnValue, true);
    }

    /**
     * 直接发送get请求并返回请求结果
     *
     * @param string $url 请求Url
     * @param string $charset 编码
     * @return string 返回内容
     *
     */
    private static function get($url, $charset = 'utf-8', $this_header = '') {
        $ch = curl_init();
        if(is_array($this_header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $returnValue = curl_exec($ch);
        self::$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($charset != 'utf-8'){
            $returnValue = iconv($charset,'utf-8',$returnValue);
        }
        return $returnValue;
    }

    /**
     * 直接发送post请求并返回请求结果
     *
     * @param string $url 请求Url
     * @param array $$arguments 参数，数组
     * @param string $charset 编码
     * @return string 返回内容
     * @return $this_header 请求URL的header头
     */
    private static function post($url, $arguments, $charset = 'utf-8', $this_header = "") {
        $postData = $arguments;
        $ch = curl_init();
        if(is_array($this_header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        /*if(class_exists("CURLFile") && !empty($arguments['media'])) {
            $file = ltrim($postData['media'],'@');
            $postData['media'] = new CURLFile($file);
        }*/
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
        $returnValue = curl_exec($ch);
        self::$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($charset != 'utf-8'){
            $returnValue = iconv($charset,'utf-8',$returnValue);
        }
        return $returnValue;
    }
}
