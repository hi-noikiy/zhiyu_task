<?php




Route::group(['prefix' => 'api'], function() {
	Route::get('/user/sendCode', 'UserController@sendCode');
	Route::post('/user/register', 'UserController@register');
	Route::post('/user/login', 'UserController@login');
	Route::get('/user/vertify', 'UserController@vertify');
	Route::post('/user/passwordReset', 'UserController@passwordReset');
	Route::get('/pay/checkConfig','PayController@checkThirdConfig');
	Route::post('oauth','UserController@oauthLogin');
	Route::get('/taskCate','UserInfoController@taskCate');
	Route::get('/hotCate','UserInfoController@hotCate');

	Route::get('/task/district', 'UserInfoController@district');
	Route::get('/work/detail','UserInfoController@showWorkDetail');
	Route::get('/user/hotService','UserInfoController@hotService');
	Route::get('/user/slideInfo','UserInfoController@slideInfo');
	Route::get('/user/serviceByCate','UserInfoController@serviceByCate');
	Route::get('/user/serviceList','UserInfoController@serviceList');

	Route::get('/task/hotTask','UserInfoController@hotTask');
	Route::post('updateSpelling', 'UserInfoController@updateSpelling');
	Route::get('/task/taskByCate','UserInfoController@taskByCate');
	Route::get('/tasks','UserController@getTaskList');
	Route::get('/user/skill', 'UserInfoController@skill');
	Route::get('/user/workerDetail','UserInfoController@workerDetail');
	Route::get('/myTask/detail','UserInfoController@showTaskDetail');
	Route::get('/agreementDetail','UserController@agreementDetail');

	Route::get('/hasIm','UserController@hasIM');
	Route::get('/user/secondSkill', 'UserInfoController@secondSkill');

	Route::get('/user/phoneCodeVertiy', 'UserController@phoneCodeVertiy');
	Route::get('/user/caseInfo', 'UserInfoController@caseInfo');
	Route::get('/app/version', 'UserController@version');
	Route::get('/iosVersion', 'UserController@iosVersion');

});




Route::group(['prefix' => 'api', 'middleware' => ['web.auth']], function () {
	Route::post('/user/updatePassword', 'UserController@updatePassword');
	Route::post('/user/updatePayCode', 'UserController@updatePayCode');
	Route::post('/user/payCodeReset', 'UserController@payCodeReset');

	Route::post('/auth/realnameAuth', 'AuthController@realnameAuth');
	Route::post('/auth/bankAuth', 'AuthController@bankAuth');
	Route::get('/auth/getBankAuth', 'AuthController@getBankAuth');
	Route::get('/auth/bankAuthInfo', 'AuthController@bankAuthInfo');
	Route::get('/auth/realnameAuthInfo', 'AuthController@realnameAuthInfo');
	Route::post('/auth/alipayAuth', 'AuthController@alipayAuth');
	Route::get('/auth/alipayAuthInfo', 'AuthController@alipayAuthInfo');
	Route::post('/auth/verifyAlipayAuthCash', 'AuthController@verifyAlipayAuthCash');
	Route::post('/auth/verifyBankAuthCash', 'AuthController@verifyBankAuthCash');

	Route::get('/user/myfocus', 'UserInfoController@myfocus');
	Route::post('/user/deleteFocus', 'UserInfoController@deleteFocus');

	Route::post('/user/deleteUser', 'UserInfoController@deleteUser');
	Route::post('/user/skillSave', 'UserInfoController@skillSave');


	Route::get('/user/addFocus','UserInfoController@insertFocusTask');


	Route::get('/myTask/index', 'TaskController@myPubTasks');
	Route::post('/myTask/createTask', 'TaskController@createTask');




	Route::get('/myTask/myAccept','TaskController@myAcceptTask');
	Route::get('/work/applauseRate','TaskController@applauseRate');

	Route::get('/work/winBid','TaskController@workWinBid');
	Route::post('/work/createWinBid','TaskController@createWinBidWork');
	Route::post('/work/createDelivery','TaskController@createDeliveryWork');
	Route::get('/work/deliveryAgree','TaskController@deliveryWorkAgree');
	Route::post('/work/deliveryRight','TaskController@deliveryWorkRight');
	Route::post('/work/evaluate','TaskController@evaluateCreate');
	Route::post('/work/comment','TaskController@commentCreate');
	Route::get('/work/getEvaluate','TaskController@getEvaluate');
	Route::post('/fileUpload','TaskController@fileUpload');
	Route::get('/fileDelete','TaskController@fileDelete');

	Route::get('/user/getUserInfo', 'UserController@getUserInfo');
	Route::get('/user/personCase', 'UserInfoController@personCase');
	Route::post('/user/addCase', 'UserInfoController@addCase');

	Route::post('/user/caseUpdate', 'UserInfoController@caseUpdate');

	Route::get('/user/getNickname', 'UserController@getNickname');
	Route::post('/user/updateNickname', 'UserController@updateNickname');
	Route::get('/user/getAvatar', 'UserController@getAvatar');
	Route::post('/user/updateAvatar', 'UserController@updateAvatar');
	Route::post('/user/updateUserInfo', 'UserController@updateUserInfo');
	Route::get('/user/messageList', 'UserController@messageList');

	Route::get('/user/myTalk', 'UserInfoController@myTalk');
	Route::get('/user/myAttention', 'UserInfoController@myAttention');
	Route::post('/user/addAttention', 'UserInfoController@addAttention');
	Route::post('/user/addMessage', 'UserInfoController@addMessage');
	Route::post('/user/updateMessStatus', 'UserInfoController@updateMessStatus');
	Route::post('/user/deleteTalk', 'UserInfoController@deleteTalk');

	Route::post('/pay/bountyByBalance','PayController@taskDepositByBalance');
	Route::get('/pay/orderInfo','PayController@createOrderInfo');
	Route::get('/pay/balance','PayController@balance');
	Route::post('/pay/cashOut','PayController@cashOut');
	Route::get('/pay/bankAccount','PayController@bankAccount');
	Route::get('/pay/alipayAccount','PayController@alipayAccount');
	Route::get('/pay/financeList','PayController@financeList');

	Route::get('/user/loginOut','UserController@loginOut');

	Route::get('/auth/bankList','AuthController@bankList');
	Route::get('/auth/alipayList','AuthController@alipayList');





	Route::post('/user/feedbackInfo', 'UserInfoController@feedbackInfo');
	Route::get('/user/helpCenter','UserInfoController@helpCenter');

	Route::get('/user/passwordCheck','UserInfoController@passwordCheck');
	Route::get('/user/moneyConfig','UserInfoController@moneyConfig');

	Route::get('/user/getCash','UserInfoController@getCash');
	Route::post('/user/postCash','PayController@postCash');


	Route::get('/noPubTask','TaskController@noPubTask');

	Route::post('/user/sendMessage','UserController@sendMessage');
	Route::get('/agreeDelivery','TaskController@agreeDelivery');
	Route::get('/guestDelivery','TaskController@guestDelivery');

	Route::get('/user/ImMessageList','UserController@ImMessageList');
	Route::get('/user/becomeFriend','UserController@becomeFriend');
	Route::get('/user/isFocusUser','UserController@isFocusUser');
	Route::get('/user/headPic','UserController@headPic');
	Route::get('/user/buyerInfo','UserInfoController@buyerInfo');
	Route::get('/user/workerInfo','UserInfoController@workerInfo');
	Route::get('/user/aboutUs','UserInfoController@aboutUs');
});


Route::get('api/alipay/notify','PayController@alipayNotify');
Route::get('api/wechatpay/notify', 'PayController@wechatpayNotify');
