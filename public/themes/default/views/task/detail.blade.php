
    <div class="g-taskposition col-xs-12 col-left">
            您的位置：首页 > 任务详情
    </div>

    <div class="col-xs-12 col-left">
        <div class="well bg-white">
            <h2 class="tasktitle cor-gray51">{{ $detail['title'] }}</h2>
        </div>
    </div>

    <div class="col-xs-12 hidden-lg clearfix col-left">
        <div class="task-sidetime well bg-white text-size14 task-timeSheet clearfix">
            <div class="pull-left p-space">
                @if($detail['status']==0)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">暂不发布</span>状态</span>
                @elseif($detail['status']==1)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">未托管</span>状态</span>
                @elseif($detail['status']==2)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">后台审核</span>状态</span>
                @elseif($detail['status']==3)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">投稿</span>状态</span>
                @elseif($detail['status']==4)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">投稿</span>状态</span>
                @elseif($detail['status']==5)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">选稿</span>状态</span>
                @elseif($detail['status']==6)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">公示</span>状态</span>
                @elseif($detail['status']==7)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">验收</span>状态</span>
                @elseif($detail['status']==8)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">互评</span>状态</span>
                @elseif($detail['status']==9)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">已结束</span>状态</span>
                @elseif($detail['status']==10)
                    <span class="text-size16">此任务当前处于：<span class="text-primary">失败</span>状态</span>
                @endif
            </div>
            <div class="pull-right">
                @if(($detail['status']==3 || $detail['status']==4 || $detail['status']==5) && $user_type==3)
                    <a href="/task/workdelivery/{{ $detail['id'] }}" class="btn btn-primary btn-blue bor-radius2 col-xs-12">立即投稿</a>
                @elseif($detail['status']==7 && $user_type==2 && $is_win_bid)
                    <a href="/task/delivery/{{ $detail['id'] }}"  class="btn btn-primary col-xs-12 btn-blue bor-radius6">去交付</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="row">
            <div class="col-lg-9 list-l col-md-12 col-left">
                    <ul class="tasknav clearfix mg-margin nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab" class="text-size16">任务详情</a>
                        </li>
                        <li>
                            <a href="#home2" data-toggle="tab" class="text-size16">投稿记录<span class="badge bg-blue">{{ $works_count }}</span></a>
                        </li>
                        @if(!empty($delivery['data']) && $user_type!=3 && ($is_delivery || $user_type==1))
                        <li>
                            <a href="#home3" data-toggle="tab" class="text-size16">交付内容<span class="badge badge-primary bg-blue">{{ $delivery_count }}</span></a>
                        </li>
                        @endif
                        @if(!empty($comment['data']))
                        <li>
                            <a href="#home4" data-toggle="tab" class="text-size16">评价<span class="badge badge-primary allbtn">{{ $comment_count }}</span></a>
                        </li>
                        @endif
                        @if(!empty($works_rights['data']))
                        <li>
                            <a href="#home5" data-toggle="tab" class="text-size16">交易维权<span class="badge badge-primary allbtn">{{ $works_rights_count }}</span></a>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content b-border0 pd-padding0">
                        <!--任务详情-->
                        <div id="home" class="tab-pane fade pd-padding30  bg-white b-border active in">
                            <!--雇主信息-->
                            <div class="row">
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-5 col-xs-6 p-space">
                                            <ul class="task-info mg-margin">
                                                <li class="h5 cor-gray51 clearfix p-space">
                                                    <span class="t-ico"></span>
                                                    雇主：<span class="maxspan-space">{{ $detail['user_name'] }}</span>&nbsp;
                                                    @if($user_type==2)
                                                        @if(Auth::check() && Auth::User()->id != $detail['uid'])
                                                            <a href="javascript:;" title="联系TA" class="taskmessico" data-toggle="modal" data-target="#myModalgz" data-values="{{ $detail['uid'] }}" data-id="{{Theme::get('is_IM_open')}}" ></a>
                                                        @endif
                                                    @endif
                                                </li>
                                                <li class="h5 cor-gray51 clearfix p-space">
                                                    <span class="t-ico t-ico1"></span>
                                                    任务分类：{{ $detail['cate_name'] }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 p-space">
                                            <ul class="task-info mg-margin">
                                                <li class="h5 cor-gray51 clearfix p-space">
                                                    <span class="t-ico t-ico2"></span>
                                                    任务类型：
                                                    @if($detail['worker_num']==1)
                                                        单人悬赏
                                                    @else
                                                        多人悬赏
                                                    @endif
                                                </li>
                                                <li class="h5 cor-gray51 clearfix p-space">
                                                    <span class="t-ico t-ico3"></span>
                                                    截止时间：{{ date('Y-m-d', strtotime($detail['delivery_deadline'])) }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- 联系我模态框 -->
                                @if(Theme::get('is_IM_open') == 2 && Auth::check() && Auth::User()->id != $detail['uid'])
                                <div class="modal fade" id="myModalgz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog  contact-me-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">联系TA</h4>
                                            </div>
                                            <form class="form-horizontal" action="seriveceCaseDetail_submit" method="post" accept-charset="utf-8">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">
                                                            <strong>标题：</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="form-field-1" name="title" class="col-xs-10 col-sm-5 title">
                                                            <input type="hidden" name="js_id" class="js_id" id="contactMeId" value="{{ $detail['uid'] }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">
                                                            <strong>内容：</strong> </label>

                                                        <div class="col-sm-9">
                                                            <textarea class="form-control col-xs-10 col-sm-5 content" id="form-field-8" name="content"></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="contactMe">确定</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="row">
                                        <div class="task-money alert taskSum">
                                            <p class="h5 cor-gray51 ">本任务已托付任务款：</p>
                                            <h2 class="text-center cor-orange text-size36 text-blod">{{ $detail['bounty'] }}<span class="text-size12">元</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--时间轴-->
                            <div data-target="#step-container" class="tab-bor row-fluid maintime clearfix task-taskdisplay" id="fuelux-wizard">
                                <ul class="wizard-steps">
                                    <li class="{{ ($detail['status']>=3)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-chevron-right"></i></span></div>
                                        <span class="title">发布需求，托管赏金</span>
                                        <span class="title">{{ date('Y.m.d',strtotime($detail['created_at'])) }}</span>
                                    </li>
                                    <li class="{{ ($detail['status']>=4)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-chevron-right"></i></span></div>
                                        <span class="title">威客投稿</span>
                                        @if($detail['status']>=4 && count($works['data'])!=0)
                                        <span class="title">{{ date('Y.m.d',strtotime($works['data'][0]['created_at'])) }}</span>
                                        @endif
                                    </li>
                                    <li class="{{ ($detail['status']>=5)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-chevron-right"></i></span></div>
                                        <span class="title">雇主选稿</span>
                                        @if($detail['status']>=5 && count($works['data'])!=0)
                                            @foreach($works['data'] as $v)
                                                @if($v['status']==1)
                                                <span class="title">{{ date('Y.m.d',strtotime($v['created_at'])) }}</span>
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                    </li>
                                    <li class="{{ ($detail['status']>=6)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-chevron-right"></i></span></div>
                                        <span class="title">中标公示</span>
                                        @if($detail['status']>=6)
                                            <span class="title">{{ date('Y.m.d',strtotime($detail['publicity_at'])) }}</span>
                                        @endif
                                    </li>
                                    <li class="{{ ($detail['status']>=7)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-chevron-right"></i></span></div>
                                        <span class="title">验收付款</span>
                                        @if($detail['status']>=7)
                                            <span class="title">{{ date('Y.m.d',strtotime($detail['checked_at'])) }}</span>
                                        @endif
                                    </li>
                                    <li class="{{ ($detail['status']==9)?'active':'' }}" data-target="#step1">
                                        <div class="clearfix"><span class="step"><i class="fa fa-check"></i></span></div>
                                        <span class="title">评价</span>
                                        @if($detail['status']==9 && !is_null($detail['end_at']))
                                            <span class="title">{{ date('Y.m.d',strtotime($detail['end_at'])) }}</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="space"></div>
                            </div>
                            <!--任务描述-->
                            <div class="task-description cor-gray51">
                                <div class="description-main">
                                    <p class="h4 description-title">任务描述</p>
                                    <div class="h5 height-line24" style="word-break:break-all">
                                        {!! $detail['desc'] !!}
                                    </div>
                                </div>
                                <div class="description-main task-taskdisplay">
                                    <div>
                                        <p class="h4 description-title"><b><i class="fa fa-paperclip fa-rotate-90"></i> 附件 <span class="text-muted">({{ count($attatchment) }})</span></b></p>
                                        <span class="hr"></span>
                                    </div>
                                    <div class="user-profile clearfix">
                                        <ul class="ace-thumbnails">
                                            @foreach($attatchment as $v)
                                                <li>
                                                    <a href="#" >
                                                        <img alt="150x150" src="{!! Theme::asset()->url('images/task-xiazai/'.matchImg($v['type']).'.png') !!}">
                                                        <div class="text">
                                                            <div class="inner"></div>
                                                        </div>
                                                    </a>
                                                    <div class="tools tools-bottom">
                                                        <a href="{{ URL('task/download',['id'=>$v['id']]) }}" target="_blank">下载</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="space"></div>

                                <div class="space"></div>
                            </div>
                        </div>
                        <!--投标记录-->
                        <div id="home2" class="tab-pane fade in">
                            <div class="tab-content bg-white task-taskdisplay">
                                <ul class="nav nav-pills mg-margin">
                                    <li class="{{ !isset($merge['work_type'])?'active':'' }}"><a href="javascript:void(0);" onclick="ajaxPageWorks($(this))"  url="{{ URL('task/ajaxPageWorks/').'/'.$detail['id']}}" class="{{ !isset($merge['work_type'])?'btn-blue':'' }}">全部</a></li>
                                    <li class="{{ (isset($merge['work_type']) && $merge['work_type']==1)?'active':'' }}"><a class="{{ (isset($merge['work_type']) && $merge['work_type']==1)?'btn-blue':'' }}" href="javascript:void(0)" onclick="ajaxPageWorks($(this))" url="{{ URL('task/ajaxPageWorks/').'/'.$detail['id'].'?'.http_build_query(['work_type'=>1]) }}">未中标<span> ({{ ($works_count-$works_bid_count) }})</span></a></li>
                                    <li class="{{ (isset($merge['work_type']) && $merge['work_type']==2)?'active':'' }}"><a class="{{ (isset($merge['work_type']) && $merge['work_type']==2)?'btn-blue':'' }}" href="javascript:void(0)" onclick="ajaxPageWorks($(this))" url="{{ URL('task/ajaxPageWorks/').'/'.$detail['id'].'?'.http_build_query(['work_type'=>2]) }}">中标<span> ({{ $works_bid_count }})</span></a></li>

                                    @if(\Illuminate\Support\Facades\Session::has('AuthUserInfo.employer'))
                                        <li><a href="{{ URL('task/stopThisTask/').'/'.$detail['id'] }}" onclick="if(confirm('你确定要停止当前任务吗？') == false) return false"> 停止竞标 </a></li>
                                    @endif
                                </ul>
                            </div>
                            @if(count($works['data'])>0)
                                @foreach($works['data'] as $v)
									@if($detail['work_status'] == 0 || $user_type==1 || (\Illuminate\Support\Facades\Session::has('AuthUserInfo') && \Illuminate\Support\Facades\Session::get('AuthUserInfo.id') == $v['uid']))
                            <div class="bidrecords">
                                <div class="evaluate row">
                                    <div class="col-md-1 col-xs-2 task-bidMedia evaluateimg">
                                        <img src="@if($v['avatar']) {{ env('AUATAR_URL') . $v['avatar'] }} @else{{ $domain.'/'.CommonClass::getAvatar($v['uid']) }}@endif"  onerror="onerrorImage('{{ Theme::asset()->url('images/defauthead.png')}}',$(this))" class="img-r"></div>
                                    <div class="col-md-11 col-xs-10 evaluatemain">
                                        <div class="evaluateinfo clearfix">
                                            <div class="pull-left">
                                                <p><b>{{ $v['user_name'] }}</b>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;好评率：<span class="text-orange">{{ CommonClass::applauseRate($v['uid']) }}%</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if($user_type==1)
                                                        @if(\Illuminate\Support\Facades\Session::has('AuthUserInfo') && \Illuminate\Support\Facades\Session::get('AuthUserInfo.id') != $v['uid'])
                                                            <a class="taskconico contactHe" data-toggle="modal" data-target="#myModalwk"data-values="{{$v['uid']}}" data="{{Theme::get('is_IM_open')}}">联系TA</a>
                                                        @endif
                                                    <a class="taskentuseico" href="{{ url('bre/serviceCaseList',['uid'=>$v['uid']]) }}">进入空间</a>
                                                    @endif
                                                </p>
                                                <p class="evaluatetime">提交于{{ $v['created_at'] }}</p>
                                            </div>
                                            @if(($detail['status']==4 || $detail['status']==5) && $user_type==1 && $v['status']==0)
                                            <div id="select-attachment-{{$v['id']}}" class="select-attachment">
                                                <div class="pull-right">
                                                    <button data-target="#myModal{{ $v['id'] }}" data-toggle="modal" class="btn btn-primary btn-blue btn-big1 bor-radius2">选TA</button>
                                                </div>
                                                <!-- 模态框（Modal） -->
                                                <div class="modal fade" id="myModal{{ $v['id'] }}" tabindex="-1" role="dialog"aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header widget-header-flat">
                                                                <span class="modal-title" id="myModalLabel">
                                                                    审核提示：
                                                                </span>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p class="h5">确定将“<span class="text-primary">{{ $v['user_name'] }}</span>”设置为中标吗？中标金额为 <span class="text-primary">{{ $detail['bounty'] }} </span>元</p>
                                                                <div class="space"></div>
                                                                <p><button class="btn btn-primary btn-sm btn-big1 btn-blue bor-radius2 win-bid" type="button" task_id="{{ $detail['id'] }}" work_id="{{ $v['id'] }}" onclick="winBid($(this))" data-dismiss="modal">确定</button> <button class="btn btn-default btn-sm btn-big1 btn-gray999 bor-radius2" type="button" data-dismiss="modal">取消</button></p>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal -->
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- 联系TA模态框 -->
                                        @if(Theme::get('is_IM_open') == 2)
                                        <div class="modal fade" id="myModalwk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog  contact-me-modal" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header ">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">联系TA</h4>
                                                    </div>
                                                    <form class="form-horizontal" action="seriveceCaseDetail_submit" method="post" accept-charset="utf-8">

                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">
                                                                    <strong>标题：</strong> </label>

                                                                <div class="col-sm-9">
                                                                    <input type="text" id="form-field-1" name="title" class="col-xs-10 col-sm-5 titleHe">
                                                                    <input type="hidden" name="js_id" class="js_id" id="contactHeId" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1">
                                                                    <strong>内容：</strong> </label>

                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control col-xs-10 col-sm-5 contentHe" id="form-field-8" name="content"></textarea>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-primary" id="contactHe">确定</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="evaluatext detail-noborder">{!! $v['desc'] !!}</div>
                                        <div class="detail-border">
                                            @if($v['status']==1 || $v['status']==2)
                                                <div class="selecte" id="selecte-{{ $v['id'] }}" ></div>
                                            @elseif($v['status']==5)
                                                <div class="weedout" id="weedout-{{ $v['id'] }}" ></div>
                                            @else
                                                <div class="selecte" id="selecte-{{ $v['id'] }}" style="display:none;"></div>
                                                <div class="weedout" id="weedout-{{ $v['id'] }}" style="display:none;"></div>
                                            @endif
                                        </div>
                                        <div>
                                            <div>
                                                <p class="h4 description-title"><b><i class="fa fa-paperclip fa-rotate-90"></i> 附件 <span class="text-muted">({{ count($v['children_attachment']) }})</span></b></p>
                                            </div>
                                            <div class="user-profile clearfix">
                                                <ul class="ace-thumbnails">
                                                    @foreach($v['children_attachment'] as $value)
                                                        <li>
                                                            <a href="#" >
                                                                <img alt="150x150" src="{!! Theme::asset()->url('images/task-xiazai/'.matchImg($value['type']).'.png') !!}">
                                                                <div class="text">
                                                                    <div class="inner"></div>
                                                                </div>
                                                            </a>
                                                            <div class="tools tools-bottom">
                                                                <a href="{{ URL('task/download',['id'=>$value['attachment_id']]) }}" target="_blank">下载</a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if(Session::has('AuthUserInfo'))
                                            <a class="evaluateshow text-under blue get-comment" url="/task/getComment" work_id = '{{ $v['id'] }}' num="0" onclick="evaluateshow($(this))"  >回复({{ count($v['children_comment']) }})</a>
                                            @else
                                            <a class="evaluateshow text-under blue" url="/task/getComment" work_id = '{{ $v['id'] }}' onclick="loginremaind($(this))"  >回复{{ count($v['children_comment']) }}</a>
                                            @endif
                                            <a class="blue text-under" work_id="{{ $v['id'] }}" onclick="report($(this))" data-toggle="modal" data-target="#modal9">举报</a>
                                        </div>
                                        <div class="evaluatehide">
                                            <div class="space"></div>
                                            <div class="widget-box">
                                                <div class="widget-body">
                                                    <div class="widget-main no-padding">
                                                        <!-- #section:pages/dashboard.conversations -->
                                                        <form>
                                                            <input id="work-comment-pid-{{ $v['id'] }}" type="hidden" name="pid" >
                                                            <div class="form-actions">
                                                                <div class="input-group">
                                                                    <input placeholder="说点什么"  type="text" class="form-control hfchat-text" name="comment" id="work-comment-answer-{{ $v['id'] }}" />
																<span class="input-group-btn">
																	<span class="btn btn-sm btn-info no-radius allbtn" url="/task/ajaxComment" type="button" work_id = "{{ $v['id'] }}" task_id="{{ $v['task_id'] }}" token="{{ csrf_token() }}" onclick='ajaxComment($(this))'>
                                                                        <i class="ace-icon fa fa-share"></i>
                                                                        提交
                                                                    </span>
																</span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="" id="work-comment-{{ $v['id'] }}" >

                                                        </div>

                                                    </div><!-- /.widget-main -->
                                                </div><!-- /.widget-body -->
                                            </div><!-- /.widget-box -->
                                        </div>
                                    </div>
                                </div>
                            </div>
								@else
									<div class="norecord">
										<div class="tab-content text-center text-gray">
											{{--<h2><i class="fa fa-exclamation-circle"></i></h2>--}}
											{{--<p>暂无消息</p>--}}
											<div class="detail-nomessage">此稿件已隐藏哦</div>
										</div>
									</div>
								@endif
                                @endforeach
                            @else
                                <div class="norecord">
                                    <div class="tab-content text-center text-gray">
                                        {{--<h2><i class="fa fa-exclamation-circle"></i></h2>--}}
                                        {{--<p>暂无消息</p>--}}
                                        <div class="detail-nomessage">暂无消息哦 ！</div>
                                    </div>
                                </div>
                            @endif

                            <div class="pull-right">
                                <ul class="pagination ">
                                    @if(!empty($works['prev_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageWorks($(this))" url="{!! URL('task/ajaxPageWorks').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$works['current_page']-1])) !!}">«</a></li>
                                    @elseif($works['last_page']>1)
                                        <li class="disabled"><span>«</span></li>
                                    @endif
                                    @if($works['last_page']>1)
                                        @for($i=1;$i<=$works['last_page'];$i++)
                                            <li class="{{ ($i==$works['current_page'])?'active disabled':'' }}"><a href="javascript:void(0)" onclick="ajaxPageWorks($(this))" url="{!! URL('task/ajaxPageWorks').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$i])) !!}">{{ $i }}</a></li>
                                        @endfor
                                    @endif
                                    @if(!empty($works['next_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageWorks($(this))" url="{!! URL('task/ajaxPageWorks').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$works['current_page']+1])) !!}">»</a></li>
                                        @elseif($works['last_page']>1)
                                            <li class="disabled"><span>»</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!--交付内容-->
                        @if(!empty($delivery['data']) && $user_type!=3  && ($is_delivery || $user_type==1))
                        <div id="home3" class="tab-pane fade in">
                            @foreach($delivery['data'] as $v)
                            <div class="bidrecords">
                                <div class="evaluate row evaluatetop">
                                    <div class="col-md-1  col-xs-2 task-bidMedia evaluateimg"><img src="{{ CommonClass::getDomain().'/'.CommonClass::getAvatar($v['uid']) }}" onerror="onerrorImage('{{ Theme::asset()->url('images/defauthead.png')}}',$(this))"></div>
                                    <div class="col-md-11 col-xs-10 evaluatemain">
                                        <div class="evaluateinfo clearfix">
                                            <div class="pull-left">
                                                <p><b>{{ $v['nickname'] }}</b> | 好评率：<span class="cor-orange">{{ CommonClass::applauseRate($v['uid']) }}%</span></p>
                                                <p class="evaluatetime">提交于{{ date('Y-m-d H:i:s',strtotime($v['created_at'])) }}</p>
                                            </div>

                                            <div class="pull-right" id="check-{{ $v['id'] }}">
                                                @if($v['status']==2 && $user_type==1)
                                                <button class="btn btn-primary btn-sm btn-blue btn-big1 bor-radius2 " data-toggle="modal" data-target="#modal{{ $v['id'] }}">验收付款</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <!--验收付款 模态框（Modal） -->
                                                <div class="modal fade" id="modal{{ $v['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header widget-header-flat">
                                                                <span class="modal-title cor-gray51 text-size14 text-blod">
                                                                    交稿提示：
                                                                </span>
                                                                <button type="button" class="bootbox-close-button close text-size14"
                                                                        data-dismiss="modal" aria-hidden="true">
                                                                    &times;
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <form action="/task/check" method="get" id="form">
                                                                    <input name="work_id" value="{{ $v['id'] }}" type="hidden"/>
                                                                    <div class="space"></div>
                                                                    <p class="cor-gray51 text-size14">请确认您是否已查看源文件，并通过验收！</p>
                                                                    <div class="clearfix text-size12">
                                                                        <label class="inline">
                                                                            <input type="checkbox" class="ace" name="agree" checked="checked" datatype="*" nullmsg="请先阅读并同意">
                                                                            <span class="lbl text-muted">&nbsp;&nbsp;&nbsp;我已阅读并同意 <a href="/bre/agree/task_delivery">《{!! $agree->name !!}》</a></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="space"></div>
                                                                    <button class="btn btn-primary btn-sm btn-big1 btn-blue bor-radius2" type="submit" >确定</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <button href="javascript:;" class="btn btn-default btn-sm btn-big1 btn-gray999 bor-radius2" data-dismiss="modal" aria-hidden="true">取消</button>
                                                                    <div class="space"></div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal -->
                                                </div>
                                                @endif
                                                @if($v['status']==2 && ($user_type==1 || ($user_type==2 && Auth::check() && $v['uid']==Auth::user()['id'])))
                                                <button class="btn btn-default btn-sm btn-big1 btn-gray999 bor-radius2 " data-toggle="modal" data-target="#modallost{{ $v['id'] }}">交易维权</button>
                                                <!--交易维权 模态框（Modal） -->
                                                <div class="modal fade" id="modallost{{ $v['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header widget-header-flat">
                                                                <span class="modal-title cor-gray51 text-size14 text-blod">
                                                                    交易维权：
                                                                </span>
                                                                <button type="button" class="bootbox-close-button close text-size14"
                                                                        data-dismiss="modal" aria-hidden="true">
                                                                    &times;
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/task/ajaxRights" class="form-horizontal text-size14 cor-gray51" role="form" method="post" >
                                                                    {{ csrf_field() }}
                                                                    <input name="task_id" value="{{ $detail['id'] }}" type="hidden" />
                                                                    <input name="work_id" value="{{ $v['id'] }}" type="hidden" />
                                                                <div class="space"></div>
                                                                <div class="clearfix">
                                                                        <div class="form-group">
                                                                            <label class="col-sm-3 control-label">维权类型：</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="row">
                                                                                    <select name="type">
                                                                                        <option value="1">违规信息</option>
                                                                                        <option value="2">虚假交稿</option>
                                                                                        <option value="3">涉嫌抄袭</option>
                                                                                        <option value="4">其他</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-3 control-label">维权原因：</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="row">
                                                                                    <textarea type="text" name="desc"   placeholder="请输入维权原因"  rows="3" cols="50"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="clearfix text-center">
                                                                    <button class="btn btn-primary btn-sm btn-big1 btn-blue bor-radius2" type="submit" >确定</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <button class="btn btn-default btn-sm btn-big1 btn-gray999 bor-radius2" data-dismiss="modal" aria-hidden="true">取消</button>
                                                                </div>
                                                                <div class="space"></div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal -->
                                                </div>
                                                @endif
                                            </div>
                                            @if($v['status']==3  && $user_type==1 && CommonClass::ownerEvalute($v['task_id'],Auth::user()['id'],$v['uid'])==0)
                                                <div class="pull-right">
                                                    <a target="_blank" href="{{ URL('/task/evaluate').'?'.http_build_query(['id'=>$v['task_id'],'work_id'=>$v['id']]) }}" class="btn btn-primary btn-sm btn-blue btn-big1 bor-radius2 ">去评价</a>
                                                </div>
                                            @elseif($v['status']==3 && $user_type==2 && CommonClass::evaluted($v['task_id'],Auth::user()['id'])==0 && $v['uid']==Auth::user()['id'])
                                                <div class="pull-right">
                                                    <a target="_blank" href="{{ URL('/task/evaluate').'?'.http_build_query(['id'=>$v['task_id'],'work_id'=>$v['id']]) }}" class="btn btn-primary btn-sm btn-blue btn-big1 bor-radius2 ">去评价</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="evaluatext" style="word-break:break-all">
                                            {!! $v['desc'] !!}
                                        </div>
                                        <div>
                                            <div>
                                                <p class="h4 description-title"><b><i class="fa fa-paperclip fa-rotate-90"></i> 附件 <span class="text-muted">({{ count($v['children_attachment']) }})</span></b></p>
                                            </div>
                                            <div class="user-profile clearfix">
                                                <ul class="ace-thumbnails">
                                                @foreach($v['children_attachment'] as $value)
                                                    <li>
                                                        <a href="#" >
                                                            <img alt="150x150" src="{!! Theme::asset()->url('images/task-xiazai/'.matchImg($value['type']).'.png') !!}">
                                                            <div class="text">
                                                                <div class="inner"></div>
                                                            </div>
                                                        </a>
                                                        <div class="tools tools-bottom">
                                                            <a href="{{ URL('task/download',['id'=>$value['attachment_id']]) }}" target="_blank">下载</a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        {{--<div class="text-right" id="">--}}
                                            {{--@if($detail['status']<8)--}}
                                            {{--<a class="cor-blue" onclick="report($(this))" work_id="{{ $v['id'] }}" data-toggle="modal" data-target="#modal9">维权</a>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="pull-right">
                                <ul class="pagination ">
                                    @if(!empty($delivery['prev_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageDelivery($(this))" url="{!! URL('task/ajaxPageDelivery').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$delivery['current_page']-1])) !!}">«</a></li>
                                    @elseif($delivery['last_page']>1)
                                        <li class="disabled"><span>«</span></li>
                                    @endif
                                    @if($delivery['last_page']>1)
                                        @for($i=1;$i<=$delivery['last_page'];$i++)
                                            <li class="{{ ($i==$delivery['current_page'])?'active disabled':'' }}"><a href="javascript:void(0)" onclick="ajaxPageDelivery($(this))" url="{!! URL('task/ajaxPageDelivery').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$i])) !!}">{{ $i }}</a></li>
                                        @endfor
                                    @endif
                                    @if(!empty($delivery['next_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageDelivery($(this))" url="{!! URL('task/ajaxPageDelivery').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$delivery['current_page']+1])) !!}">»</a></li>
                                    @elseif($delivery['last_page']>1)
                                        <li class="disabled"><span>»</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @endif
                        <!--评价-->
                        @if(!empty($comment['data']))
                        <div id="home4" class="tab-pane fade in">
                            <div class="tab-content bg-white task-taskdisplay">
                                <ul class="nav nav-pills mg-margin">
                                    <li class="{{ (!isset($merge['evaluate_type']) && !isset($merge['evaluate_from']))?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'] }}" class="btn-blue">全部</a></li>
                                    <li class="{{ (isset($merge['evaluate_type']) && $merge['evaluate_type']==1)?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'].'?'.http_build_query(['evaluate_type'=>1]) }}">好评<span> ({{ $good_comment }})</span></a></li>
                                    <li class="{{ (isset($merge['evaluate_type']) && $merge['evaluate_type']==2)?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'].'?'.http_build_query(['evaluate_type'=>2]) }}">中评<span> ({{ $middle_comment }})</span></a></li>
                                    <li class="{{ (isset($merge['evaluate_type']) && $merge['evaluate_type']==3)?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'].'?'.http_build_query(['evaluate_type'=>3]) }}">差评<span> ({{ $bad_comment }})</span></a></li>
                                    <li class="{{ (isset($merge['evaluate_from']) && $merge['evaluate_from']==1)?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'].'?'.http_build_query(['evaluate_from'=>1]) }}">给威客</a></li>
                                    <li class="{{ (isset($merge['evaluate_from']) && $merge['evaluate_from']==2)?'active':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{{ URL('task/ajaxPageComment/').'/'.$detail['id'].'?'.http_build_query(['evaluate_from'=>2]) }}">给雇主</a></li>
                                </ul>
                            </div>
                            @foreach($comment['data'] as $v)
                            <div class="bidrecords">
                                <div class="evaluate">
                                    <div class="record pd-pdtp0">
                                        <div class="row">
                                            <div class="col-md-1 col-xs-2 task-bidMedia evaluateimg"><img src="{{ CommonClass::getDomain().'/'.$v['avatar'] }}" onerror="onerrorImage('{{ Theme::asset()->url('images/defauthead.png')}}',$(this))"></div>
                                            <div class="col-md-11 col-xs-10 evaluatemain">
                                                <div class="evaluateinfo">
                                                    <div>
                                                        <p><b>{{ $v['nickname'] }}</b>
                                                            @if($v['type']==1)
                                                            <span class="flower1">好评</span>
                                                            @elseif($v['type']==2)
                                                            <span class="flower2">中评</span>
                                                            @elseif($v['type']==3)
                                                            <span class="flower3">差评</span>
                                                            @endif
                                                        </p>
                                                        <p class="evaluatetime">提交于{{ date('Y-m-d H:i:s',strtotime($v['created_at'])) }}</p>
                                                    </div>
                                                </div>
                                                <div class="evaluatext">{{ $v['comment'] }}</div>
                                                <div class="recordstar">
                                                    @if($detail['uid']!=$v['to_uid'])
                                                    <div class="mg-right visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                        工作速度：
                                                        @for($i=0;$i<$v['speed_score'];$i++)
                                                            <span class="rec-active"></span>
                                                        @endfor
                                                        @for($i=0;$i<(5-$v['speed_score']);$i++)
                                                            <span></span>
                                                        @endfor
                                                    </div>
                                                    <div class="mg-right visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                        工作质量：
                                                        @for($i=0;$i<$v['quality_score'];$i++)
                                                            <span class="rec-active"></span>
                                                        @endfor
                                                        @for($i=0;$i<(5-$v['quality_score']);$i++)
                                                            <span></span>
                                                        @endfor
                                                    </div>
                                                    <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                        工作态度：
                                                        @for($i=0;$i<$v['attitude_score'];$i++)
                                                            <span class="rec-active"></span>
                                                        @endfor
                                                        @for($i=0;$i<(5-$v['attitude_score']);$i++)
                                                            <span></span>
                                                        @endfor
                                                    </div>
                                                     @else
                                                    <div class="mg-right visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                        付款及时性：
                                                        @for($i=0;$i<$v['speed_score'];$i++)
                                                            <span class="rec-active"></span>
                                                        @endfor
                                                        @for($i=0;$i<(5-$v['speed_score']);$i++)
                                                            <span></span>
                                                        @endfor
                                                    </div>
                                                    <div class="mg-right visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                        合作愉快：
                                                        @for($i=0;$i<$v['quality_score'];$i++)
                                                            <span class="rec-active"></span>
                                                        @endfor
                                                        @for($i=0;$i<(5-$v['quality_score']);$i++)
                                                            <span></span>
                                                        @endfor
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="pull-right">
                                <ul class="pagination ">
                                    @if(!empty($comment['prev_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{!! URL('task/ajaxPageComment').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$comment['current_page']-1])) !!}">«</a></li>
                                    @elseif($comment['last_page']>1)
                                        <li class="disabled"><span>«</span></li>
                                    @endif
                                    @if($comment['last_page']>1)
                                        @for($i=1;$i<=$comment['last_page'];$i++)
                                            <li class="{{ ($i==$comment['current_page'])?'active disabled':'' }}"><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{!! URL('task/ajaxPageComment').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$i])) !!}">{{ $i }}</a></li>
                                        @endfor
                                    @endif
                                    @if(!empty($comment['next_page_url']))
                                        <li><a href="javascript:void(0)" onclick="ajaxPageComment($(this))" url="{!! URL('task/ajaxPageComment').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$comment['current_page']+1])) !!}">»</a></li>
                                    @elseif($comment['last_page']>1)
                                        <li class="disabled"><span>»</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @endif
                        {{--维权--}}
                        @if(!empty($works_rights['data']) && $user_type!=3  && ($is_rights || $user_type==1))
                        <div id="home5" class="tab-pane fade in">
                                @foreach($works_rights['data'] as $v)
                                    <div class="bidrecords">
                                        <div class="evaluate row evaluatetop">
                                            <div class="col-md-1  col-xs-2 task-bidMedia evaluateimg"><img src="{{ CommonClass::getDomain().'/'.CommonClass::getAvatar($v['uid']) }}" onerror="onerrorImage('{{ Theme::asset()->url('images/defauthead.png')}}',$(this))"></div>
                                            <div class="col-md-11 col-xs-10 evaluatemain">
                                                <div class="evaluateinfo clearfix">
                                                    <div class="pull-left">
                                                        <p><b>{{ $v['nickname'] }}</b> | 好评率：<span class="cor-orange">{{ CommonClass::applauseRate($v['uid']) }}%</span></p>
                                                        <p class="evaluatetime">提交于{{ date('Y-m-d H:i:s',strtotime($v['created_at'])) }}</p>
                                                    </div>
                                                </div>
                                                <div class="evaluatext" style="word-break:break-all">
                                                    {!! htmlspecialchars_decode($v['desc']) !!}
                                                </div>
                                                <div>
                                                    <div>
                                                        <p class="h4 description-title"><b><i class="fa fa-paperclip fa-rotate-90"></i> 附件 <span class="text-muted">({{ count($v['children_attachment']) }})</span></b></p>
                                                    </div>
                                                    <div class="user-profile clearfix">
                                                        <ul class="ace-thumbnails">
                                                            @foreach($v['children_attachment'] as $value)
                                                                <li>
                                                                    <a href="#" >
                                                                        <img alt="150x150" src="{!! Theme::asset()->url('images/task-xiazai/'.matchImg($value['type']).'.png') !!}">
                                                                        <div class="text">
                                                                            <div class="inner"></div>
                                                                        </div>
                                                                    </a>
                                                                    <div class="tools tools-bottom">
                                                                        <a href="{{ URL('task/download',['id'=>$value['id']]) }}" target="_blank">下载</a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="pull-right">
                                    <ul class="pagination ">
                                        @if(!empty($works_rights['prev_page_url']))
                                            <li><a href="javascript:void(0)" onclick="ajaxPageRights($(this))" url="{!! URL('task/ajaxPageRights').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$works_rights['current_page']-1])) !!}">«</a></li>
                                        @elseif($works_rights['last_page']>1)
                                            <li class="disabled"><span>«</span></li>
                                        @endif
                                        @if($works_rights['last_page']>1)
                                            @for($i=1;$i<=$works_rights['last_page'];$i++)
                                                <li class="{{ ($i==$works_rights['current_page'])?'active disabled':'' }}"><a href="javascript:void(0)" onclick="ajaxPageRights($(this))" url="{!! URL('task/ajaxPageRights').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$i])) !!}">{{ $i }}</a></li>
                                            @endfor
                                        @endif
                                        @if(!empty($works_rights['next_page_url']))
                                            <li><a href="javascript:void(0)" onclick="ajaxPageRights($(this))" url="{!! URL('task/ajaxPageRights').'/'.$detail['id'].'?'.http_build_query(array_merge($merge,['page'=>$works_rights['current_page']+1])) !!}">»</a></li>
                                        @elseif($works_rights['last_page']>1)
                                            <li class="disabled"><span>»</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="space"></div>
                    <div class="space"></div>
            </div>
            <div class="col-lg-3 task-l taskMedia visible-lg-block col-left">
                {{--中标提示--}}
                <div class="taskside taskside-points ">
                    <div class="task-sidetime">
                        <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block col-xs-6">
                            <div class="row taskside-points-border">
                                <p class="cor-grayac text-center text-size12">预期中标</p>
                                <p class="text-size20 text-center mg-margin text-blod">{{ $detail['worker_num'] }}</p>
                            </div>
                        </div>
                        <div class="visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block col-xs-6">
                            <div class="row">
                                <p class="cor-grayac text-center text-size12">已中标</p>
                                <p class="text-size20 text-center mg-margin text-primary text-blod">{{ $works_winbid_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="taskside">
                    <div class="task-sidetime text-center">
                        @if($detail['status']==0)
                        <p class="h4">此任务当前处于：<span class="text-primary">暂不发布</span>状态</p>
                        @elseif($detail['status']==1)
                        <p class="h4">此任务当前处于：<span class="text-primary">未托管</span>状态</p>
                        @elseif($detail['status']==2)
                        <p class="h4">此任务当前处于：<span class="text-primary">后台审核</span>状态</p>
                        @elseif($detail['status']==3 && strtotime($detail['begin_at'])>time())
                        <p class="h4">此任务当前处于：<span class="text-primary">审核通过</span>状态</p>
                        @elseif($detail['status']==3 && strtotime($detail['begin_at'])<time())
                        <p class="h4">此任务当前处于：<span class="text-primary">投稿</span>状态</p>
                        @elseif($detail['status']==4)
                        <p class="h4">此任务当前处于：<span class="text-primary">投稿</span>状态</p>
                        @elseif($detail['status']==5)
                        <p class="h4">此任务当前处于：<span class="text-primary">选稿</span>状态</p>
                        @elseif($detail['status']==6)
                        <p class="h4">此任务当前处于：<span class="text-primary">公示</span>状态</p>
                        @elseif($detail['status']==7)
                        <p class="h4">此任务当前处于：<span class="text-primary">验收</span>状态</p>
                        @elseif($detail['status']==8)
                        <p class="h4">此任务当前处于：<span class="text-primary">互评</span>状态</p>
                        @elseif($detail['status']==9)
                        <p class="h4">此任务当前处于：<span class="text-primary">已结束</span>状态</p>
                        @elseif($detail['status']==10)
                        <p class="h4">此任务当前处于：<span class="text-primary">失败</span>状态</p>
                        @elseif($detail['status']==11)
                        <p class="h4">此任务当前处于：<span class="text-primary">维权</span>状态</p>
                        @endif
                        @if($detail['status']==3 && strtotime($detail['begin_at'])>time())
                            <p>离投稿开始还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['begin_at'])) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==3 && strtotime($detail['begin_at'])<time())
                            <p>离投稿结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['delivery_deadline'])) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==4)
                            <p>离投稿结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['delivery_deadline'])) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==5)
                            <div style="display:none">
                                {!!  $task_select_work = CommonClass::getConfig('task_select_work') !!}
                                {!!  $task_select_work = $task_select_work*24*3600 !!}
                            </div>
                            <p>离选稿结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['selected_work_at'])+$task_select_work) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==6)
                            <div style="display:none">
                                {!!  $task_publicity_day = CommonClass::getConfig('task_publicity_day') !!}
                                {!!  $task_publicity_day = $task_publicity_day*24*3600 !!}
                            </div>
                            <p>离公示结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['publicity_at'])+$task_publicity_day) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==7)
                            <div style="display:none">
                                {!!  $task_delivery_max_time = CommonClass::getConfig('task_delivery_max_time') !!}
                                {!!  $task_check_time_limit = CommonClass::getConfig('task_check_time_limit') !!}
                                {!!  $task_delivery_max_time = ($task_delivery_max_time+$task_check_time_limit)*24*3600 !!}
                            </div>
                            <p>离验收结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['checked_at'])+$task_delivery_max_time) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==8)
                            <div style="display:none">
                                {!!  $task_comment_time_limit = CommonClass::getConfig('task_comment_time_limit') !!}
                                {!!  $task_comment_time_limit = $task_comment_time_limit*24*3600 !!}
                            </div>
                            <p>离互评结束还剩：</p>
                            <p class="text-center"><b  delivery_deadline="{{ date('Y/m/d H:i:s',strtotime($detail['comment_at'])+$task_comment_time_limit) }}" class="cor-orange text-size22 timer-check"></b></p>
                        @endif
                        @if($detail['status']==11)
                            <p>请等待后台的处理结果</p>
                        @endif
                    </div>
                    @if(($detail['status']==3 || $detail['status']==4 || $detail['status']==5) && $user_type==3)
                        <div class="text-center"><a href="/task/workdelivery/{{ $detail['id'] }}"  class="btn btn-primary btn-block allbtn btn-blue bor-radius2">立即投稿</a></div>
                    @elseif($detail['status']==7 && $user_type==2 && $is_win_bid && !$is_delivery)
                        <div class="text-center"><a href="/task/delivery/{{ $detail['id'] }}" class="btn btn-primary btn-block allbtn">去交付</a></div>
                    @endif
                </div>
                @if(count($hotList))
                <div class=" taskside1 taskside">
                    <h4 class="mg-margin text-size14 cor-gray51"><strong>{!! $targetName !!}</strong></h4>

                    <div class="">
                        <ul class="mg-margin one-noborbot">
                            @foreach($hotList as $v)
                                <li class="clearfix">
                                    <p class="h5"><a href="{!!$v['url']!!}" class="cor-gray51 text-size14">{!! $v['recommend_name'] !!}</a></p>
                                    <div class="clearfix text-size14">
                                        <span class="pull-left cor-orange">￥{{ number_format($v['bounty'],2) }}</span><span class="pull-right cor-gray97">{{ date('Y.m.d',strtotime($v['created_at'])) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="taskside1" >
                    @if(count($ad))
                    <a href="{!! $ad[0]['ad_url'] !!}"><img src="{!! URL($ad[0]['ad_file']) !!}" alt="" class="img-responsive" width="100%"></a>
                    @else
                    <img src="{{ Theme::asset()->url('images/task-gg.png') }}" alt="" class="img-responsive" width="100%">
                    @endif
                </div>
                <div class="space"></div>
            </div>
        </div>
    </div>
</div>
<!--维权举报 模态框（Modal） -->
<form action="/task/report" method="post" enctype="multipart/form-data" id="report-form">
    {{ csrf_field() }}
    <input type="hidden" name="task_id" value="{{ $detail['id'] }}">
    <input type="hidden" name="work_id" value="" id="report-work-id">
<div class="modal fade" id="modal9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header widget-header-flat">
                <span class="modal-title cor-gray51 text-size14 text-blod">
                    举报：
                </span>
                <button type="button" class="bootbox-close-button close text-size14" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="space"></div>
                <div class="clearfix">
                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label row">举报类型：</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <select name="type">
                                        <option value="1">滥发广告</option>
                                        <option value="2">违规信息</option>
                                        <option value="3">虚假交换</option>
                                        <option value="4">涉嫌抄袭</option>
                                        <option value="5">重复交稿</option>
                                        <option value="6">其他</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label row">举报内容：</label>
                            <div class="col-sm-8 ">
                                <div class="row ">
                                    <textarea type="text" name="desc" placeholder="请输入维权内容"  rows="3" class="col-xs-12 jbchat-text"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-3 control-label row">上传附件：</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <input multiple="true" name="file[]" type="file" id="id-input-file-3" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="clearfix text-center">
                    <button class="btn btn-primary btn-sm btn-big1 btn-blue bor-radius2" type="button" onclick="ajaxReport()" data-dismiss="modal" aria-hidden="true">确定</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default btn-sm btn-big1 btn-gray999 bor-radius2" data-dismiss="modal" aria-hidden="true">取消</button>
                </div>
                <div class="space"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
</form>

{!! Theme::widget('popup')->render() !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('issuetask','css/taskbar/issuetask.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('taskcommon','css/taskbar/taskcommon.css') !!}

{{--回复--}}
{!! Theme::asset()->container('custom-js')->usepath()->add('ace-extra','plugins/ace/js/ace-extra.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('easypiechart','plugins/ace/js/jquery.easypiechart.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('sparkline','plugins/ace/js/jquery.sparkline.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('flot.min','plugins/ace/js/flot/jquery.flot.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('flot.pie','plugins/ace/js/flot/jquery.flot.pie.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('flot.resize','plugins/ace/js/flot/jquery.flot.resize.min.js') !!}
{{--{!! Theme::asset()->container('custom-js')->usepath()->add('flot.resize','plugins/ace/js/jquery.slimscroll.min.js') !!}--}}
{{--上传--}}
{{--{!! Theme::asset()->container('custom-js')->usepath()->add('dropzone', 'js/ace/dropzone.min.js') !!}--}}
        <!-- ace scripts -->
{!! Theme::asset()->container('custom-js')->usepath()->add('ace-elements','plugins/ace/js/ace-elements.min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('ace','plugins/ace/js/ace.min.js') !!}

{!! Theme::asset()->container('custom-js')->usepath()->add('taskdetail','js/doc/taskdetail.js') !!}


{!! Theme::asset()->container('custom-js')->usepath()->add('checkbox', 'js/doc/checkbox.js') !!}
{!! Theme::asset()->container('specific-css')->usepath()->add('validform-css','plugins/jquery/validform/css/style.css') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('validform-js','plugins/jquery/validform/js/Validform_v5.3.2_min.js') !!}

