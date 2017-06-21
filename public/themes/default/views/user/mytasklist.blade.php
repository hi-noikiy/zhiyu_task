<div class="g-main g-releasetask">
    <h4 class="text-size16 cor-blue2f u-title">我发布的任务</h4>
    <div class="space-12"></div>
    <div class="clearfix g-reletaskhd hidden-xs">
        <form action="/user/myTasksList" method="get">
            <div class="pull-left">
                <div class="pull-left">
                    <select class="form-control" name="type" disabled>
                        {{--<option value="0" {{ (empty($_GET['type']) || $_GET['type']==0)?'selected':'' }}>类型</option>--}}
                        <option value="1" {{ (!empty($_GET['type']) && $_GET['type']==1)?'selected':'' }}>悬赏</option>
                    </select>
                </div>
                <div class="pull-left">
                    <select class="form-control" name="status">
                        <option value="0" {{ (empty($_GET['status']) || $_GET['status']==0)?'selected':'' }}>全部状态</option>
                        <option value="1" {{ (!empty($_GET['status']) && $_GET['status']==1)?'selected':'' }}>工作中</option>
                        <option value="2" {{ (!empty($_GET['status']) && $_GET['status']==2)?'selected':'' }}>选稿中</option>
                        <option value="3" {{ (!empty($_GET['status']) && $_GET['status']==3)?'selected':'' }}>交付中</option>
                        <option value="4" {{ (!empty($_GET['status']) && $_GET['status']==4)?'selected':'' }}>已结束</option>
                        <option value="5" {{ (!empty($_GET['status']) && $_GET['status']==5)?'selected':'' }}>其他</option>
                    </select>
                </div>
                <div class="pull-left">
                    <select class="form-control" name="time">
                        <option value="0" {{ (empty($_GET['time']) || $_GET['time']==0)?'selected':'' }}>时间段</option>
                        <option value="1" {{ (!empty($_GET['time']) && $_GET['time']==1)?'selected':'' }}>1个月</option>
                        <option value="2" {{ (!empty($_GET['time']) && $_GET['time']==2)?'selected':'' }}>3个月</option>
                        <option value="3" {{ (!empty($_GET['time']) && $_GET['time']==3)?'selected':'' }}>6个月</option>
                    </select>
                </div>
                <button type="submit">
                    <i class="fa fa-search text-size16 cor-graybd"></i> 搜索
                </button>
            </div>
        </form>
        <div class="pull-right">
            <a class="text-size14 cor-blue2f visible-lg-block" href="/user/myTasksList"><i class="fa fa-list-ul"></i></a>
            <a class="text-size14 cor-graybd visible-lg-block" href="/user/myTaskAxis"><i class="fa fa-list-ul fa-rotate-90"></i></a>
            <div class="text-size14 cor-graybd g-releasechart visible-lg-block" href="javascript:;">
                <i class="fa fa-pie-chart"></i>
                <div class="g-releasehidea"></div>
                <div class="g-releasehide">
                    <div>
                        <div>饼图统计</div>
                        @if(!$pie_data)
                        <div class="widget-body">
                            <div class="widget-main">
                                <!-- #section:plugins/charts.flotchart -->
                                <div class="g-userchartno">您还没有发布过任务 </div>
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                        @else
                        <div class="widget-body">
                            <div class="widget-main">
                                <!-- #section:plugins/charts.flotchart -->
                                <div id="piechart-placeholder"></div>
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="space-6"></div>
<ul id="useraccept">
    @if(count($my_tasks)>0)
    @foreach($my_tasks as $v)
        <li class="row width590">
        <div class="col-sm-1 col-xs-2 usercter"><img src="@if(Theme::get('avatar')) {{CommonClass::getDomain().'/'.Theme::get('avatar')}} @else {!! Theme::asset()->url('images/default_avatar.png') !!} @endif" ></div>

        <div class="col-sm-11 col-xs-10 usernopd">
            <div class="col-sm-9 col-xs-8">
                <div class="text-size14 cor-gray51"><span class="cor-orange">￥{{ $v['bounty'] }}</span>&nbsp;&nbsp;<a target="_blank" class="cor-blue42" href="/task/{{ $v['id'] }}">{{ $v['title'] }}</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;{{ $status[$v['status']] }}</div>
                <div class="space-6"></div>
                <p class="cor-gray87"><i class="ace-icon fa fa-user bigger-110 cor-grayd2"></i> {{ $v['nickname'] }}&nbsp;&nbsp;&nbsp;<i class="fa fa-eye cor-grayd2"></i> {{ $v['view_count'] }}人浏览/{{ $v['delivery_count'] }}人投稿&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o cor-grayd2"></i> {{ date('d',time()-strtotime($v['created_at'])) }}天前&nbsp;&nbsp;&nbsp;<i class="fa fa-unlock-alt cor-grayd2"></i> {{ ($v['bounty_status']==1)?'已托管赏金':'待托管赏金' }}</p>
                <div class="space-6"></div>
                <p class="cor-gray51 p-space">{!! strip_tags(htmlspecialchars_decode($v['desc'])) !!} </p>
                <div class="space-2"></div>
                <div class="g-userlabel"><a href="">{{ $v['cate_name'] }}</a>
                    @if($v['region_limit']==1)
                        <a href="">{{ $v['province_name'].$v['city_name'] }}</a>
                    @endif
                </div>
            </div>
            <div class="col-sm-3 col-xs-4 text-right hiden590"><a target="_blank" class="btn-big bg-blue bor-radius2 hov-blue1b" href="/task/{{ $v['id'] }}">查看</a></div>
            <div class="col-xs-12"><div class="g-userborbtm"></div></div>
        </div>

    </li>
    @endforeach
    @else
        <div class="space-30"></div>
        <div class="space-30"></div>
        <div class="text-center">
            <p class="cor-gray51 text-size20">抱歉！没有找到符合以上条件的任务</p>
            <p class="cor-gray87 text-size14">您可以重新再进行筛选 或</p>
            <div class="space-10"></div>
            <a class="btn-big bg-blue text-size18 bor-radius2" href="/task/create">发布任务</a>
        </div>
    @endif
</ul>
<div class="space-20"></div>
<div class="dataTables_paginate paging_bootstrap">
    <ul class="pagination">
        {!! $my_tasks->appends($_GET)->render() !!}
    </ul>
</div>
</div>
{!! Theme::asset()->container('custom-css')->usepath()->add('usercenter','css/usercenter/usercenter.css') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('nopie','js/doc/nopie.js') !!}
@if($pie_data)
{!! Theme::widget('pie',['pie_data'=>$pie_data])->render() !!}
@endif

