<?php




Route::group(['prefix' => 'task','middleware' => 'auth'], function() {

	
	Route::get('/create','IndexController@create')->name('taskCreatePage');
	Route::post('/createTask','IndexController@createTask')->name('taskCreate');
	Route::post('/fileUpload','IndexController@fileUpload')->name('fileCreate');
	Route::get('/fileDelet','IndexController@fileDelet')->name('fileDelete');
	Route::get('/bounty/{id}','IndexController@bounty')->name('bountyPage');
	Route::get('/getTemplate','IndexController@getTemplate')->name('ajaxTemplate');
	Route::get('/preview','IndexController@preview')->name('previewPage');
	Route::get('/release/{id}','IndexController@release')->name('releaseDetail');
	Route::get('/tasksuccess/{id}','IndexController@tasksuccess')->name('tasksuccess');
	
	Route::post('/workCreate','DetailController@workCreate')->name('workCreate');
	Route::get('/workdelivery/{id}','DetailController@work')->name('workdeliveryPage');

	Route::post('/ajaxAttatchment','DetailController@ajaxWorkAttatchment')->name('ajaxCreateAttatchment');
	Route::get('/delAttatchment','DetailController@delAttatchment')->name('attatchmentDelete');
	Route::get('/winBid/{work_id}/{task_id}','DetailController@winBid')->name('winBid');
	Route::get('/download/{id}','DetailController@download')->name('download');
	Route::get('/delivery/{id}','DetailController@delivery')->name('taskdeliveryPage');
	Route::post('/deliverCreate','DetailController@deliverCreate')->name('deliverCreate');
	Route::get('/check','DetailController@workCheck')->name('check');
	Route::get('/lostCheck','DetailController@lostCheck')->name('lostCheck');
	Route::get('/evaluate','DetailController@evaluate')->name('evaluatePage');
	Route::post('/evaluateCreate','DetailController@evaluateCreate')->name('evaluateCreate');
	
	Route::post('/ajaxRights','DetailController@ajaxRights')->name('ajaxCreateRights');
	
	Route::post('/report','DetailController@report')->name('reportCreate');

	
	Route::get('/getComment/{id}','DetailController@getComment')->name('commentList');
	Route::post('/ajaxComment','DetailController@ajaxComment')->name('ajaxCreateComment');

	
	Route::post('/bountyUpdate','IndexController@bountyUpdate')->name('bountyUpdate');
	Route::get('/result','IndexController@result')->name('resultCreate');
	Route::post('/notify','IndexController@notify')->name('notifyCreate');
		
	Route::get('/weixinNotify','IndexController@weixinNotify')->name('weixinNotifyCreate');

	
	Route::get('/ajaxcity','IndexController@ajaxcity')->name('ajaxcity');
	Route::get('/ajaxarea','IndexController@ajaxarea')->name('ajaxarea');

	
	Route::get('/imgupload','IndexController@imgupload')->name('imgupload');
});
Route::group(['prefix'=>'task'],function(){


	
	Route::get('/','IndexController@tasks')->name('taskList');
	
	Route::get('/{id}','DetailController@index')->name('taskDetailPage')->where('id', '[0-9]+');;

	
	Route::get('/successCase','SuccessCaseController@index')->name('successCaseList');
	Route::get('/successDetail/{id}','SuccessCaseController@detail')->name('successDetail');

	
	Route::post('/checkbounty','IndexController@checkBounty')->name('checkbounty');
	Route::post('/checkdeadline','IndexController@checkDeadline')->name('checkdeadline');

	
	Route::get('/ajaxPageWorks/{id}','DetailController@ajaxPageWorks')->name('ajaxPageWorks');
	Route::get('/ajaxPageDelivery/{id}','DetailController@ajaxPageDelivery')->name('ajaxPageDelivery');
	Route::get('/ajaxPageComment/{id}','DetailController@ajaxPageComment')->name('ajaxPageComment');

	
	Route::get('/collectionTask/{task_id}','IndexController@collectionTask');
	Route::post('/collectionTask','IndexController@postCollectionTask');



});
