<div class="g-main g-message g-releasetask">
    <h4 class="text-size16 cor-blue2f u-title">我的提问</h4>
    <div class="space-12"></div>
    <div class="clearfix hidden-xs">
        <form action="{{ URL('user/myquestion') }}" method="get" id="screen_form">
            <div class="control-group pull-left">
                <label>
                    <input name="type" type="radio" class="ace screen" value=0 {{ (empty($_GET['type']) || $_GET['type']==0)?'checked':'' }}>
                    <span class="lbl"> 全部</span>
                </label>
                <label>
                    <input name="type" type="radio" class="ace screen" value=1 {{ (!empty($_GET['type']) && $_GET['type']==1)?'checked':'' }}>
                    <span class="lbl"> 等待处理</span>
                </label>
                <label>
                    <input name="type" type="radio" class="ace screen" value=2 {{ (!empty($_GET['type']) && $_GET['type']==2)?'checked':'' }}>
                    <span class="lbl"> 审核失败</span>
                </label>
                <label>
                    <input name="type" type="radio" class="ace screen" value=3 {{ (!empty($_GET['type']) && $_GET['type']==3)?'checked':'' }}>
                    <span class="lbl"> 未解决</span>
                </label>
                <label>
                    <input name="type" type="radio" class="ace screen" value=4  {{ (!empty($_GET['type']) && $_GET['type']==4)?'checked':'' }}>
                    <span class="lbl"> 已解决</span>
                </label>
            </div>
        </form>
    </div>
    <div class="space-6"></div>
        @if($myquestion_toArray['total']!=0)
        <ul id="useraccept">
            @foreach($myquestion_toArray['data'] as $v)
            <li class="row width590">
                <div class="col-sm-1 col-xs-2 usercter">
                    <img src="{{ (!empty($v['avatar']))?$domain.'/'.$v['avatar']:Theme::asset()->url('images/defauthead.png') }}" onerror="onerrorImage('{{ Theme::asset()->url('images/defauthead.png')}}',$(this))">
                </div>
                <div class="col-sm-11 col-xs-10 usernopd">
                    <div class="col-sm-9 col-xs-8">
                        <div class="text-size14 cor-gray51"><a class="cor-blue42" href="">{{ $v['discription'] }}</a></div>
                        <div class="space-6"></div>
                        <p class="cor-gray87"><i class="ace-icon fa fa-commenting bigger-110 cor-grayd2"></i> {{ $v['answernum'] }}人回答&nbsp;&nbsp;&nbsp;<i class="fa fa-eye cor-grayd2"></i> {{ $v['num'] }}人看过</p>
                        <div class="space-6"></div>
                        <div class="space-2"></div>
                        <div class="g-userlabel"><a href="javascript:;">{{ $v['category_name'] }}</a></div>

                    </div>
                    <div class="col-sm-3 col-xs-4 text-right hiden590"><a class="btn-big bg-blue bor-radius2 hov-blue1b" target="_blank" href="">查看</a></div>
                    <div class="col-xs-12"><div class="g-userborbtm"></div></div>
                </div>
            </li>
            @endforeach

        </ul>
        @else
        <div class="g-nomessage">暂无信息哦 ！</div>
        @endif
    <div class="space-20"></div>
    <div class="dataTables_paginate paging_bootstrap">
        {!! $myquestion->appends($_GET)->render() !!}
    </div>
</div>

{!! Theme::asset()->container('custom-css')->usepath()->add('messages','css/usercenter/messages/messages.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('usercenter','css/usercenter/usercenter.css') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('ownercomment','js/doc/ownercomment.js') !!}
