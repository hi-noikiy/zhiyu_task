<div class="g-main g-releasetask">
    <h4 class="text-size16 cor-blue2f u-title">我承接的任务</h4>
    <div class="space-12"></div>
    <div class="clearfix g-reletaskhd hidden-xs">
        <form action="/user/acceptTasksList" method="get">
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
                        <option value="4" {{ (!empty($_GET['status']) && $_GET['status']==5)?'selected':'' }}>其它</option>
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
            <a class="text-size14 cor-blue2f visible-lg-block" href="/user/acceptTasksList"><i class="fa fa-list-ul"></i></a>
            <a class="text-size14 cor-graybd visible-lg-block" href="/user/myTask"><i class="fa fa-list-ul fa-rotate-90"></i></a>
            <div class="text-size14 cor-graybd g-releasechart visible-lg-block hidden-xs hidden-sm hidden-md" href="javascript:;">
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
    @if(count($my_tasks) && $my_tasks['total'])
    <ul id="useraccept">
        @foreach($my_tasks['data'] as $v)
            <li class="row width590">
                <div class="col-sm-1 col-xs-2 usercter">
                    <img src="{!! url($v['avatar']) !!}" onerror="onerrorImage('{{ Theme::asset()->url('images/default_avatar.png')}}',$(this))">
                </div>


                <div class="col-sm-11 col-xs-10 usernopd">
                    <div class="col-sm-9 col-xs-8">
                        <div class="text-size14 cor-gray51"><span class="cor-orange">￥{{ $v['bounty'] }}</span>&nbsp;&nbsp;<a class="cor-blue42" href="/task/{{ $v['id'] }}">{{ $v['title'] }}</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;{{ $v['status_text'] }}</div>
                        <div class="space-6"></div>
                        <p class="cor-gray87"><i class="ace-icon fa fa-user bigger-110 cor-grayd2"></i> {{ $v['nickname'] }}&nbsp;&nbsp;&nbsp;<i class="fa fa-eye cor-grayd2"></i> {{ $v['view_count'] }}人浏览/{{ $v['delivery_count'] }}人投稿&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o cor-grayd2"></i> {{ date('d',time()-strtotime($v['created_at'])) }}天前&nbsp;&nbsp;&nbsp;<i class="fa fa-unlock-alt cor-grayd2"></i> {{ ($v['bounty_status']==1)?'已托管赏金':'待托管赏金' }}</p>
                        <div class="space-6"></div>
                        <p class="cor-gray51 p-space">{!! str_limit(strip_tags(htmlspecialchars_decode($v['desc'])),120) !!}</p>
                        <div class="space-2"></div>
                        <div class="g-userlabel">@if($v['cate_name'])<a href="">{{ $v['cate_name'] }}</a>@endif<a href="">湖北武汉</a></div>
                    </div>
                    <div class="col-sm-3 col-xs-4 text-right hiden590"><a class="btn-big bg-blue bor-radius2 hov-blue1b" target="_blank" href="/task/{{ $v['id'] }}">查看</a></div>
                    <div class="col-xs-12"><div class="g-userborbtm"></div></div>
                </div>
            </li>
        @endforeach
    </ul>
    @else
        <div class="g-nomessage">暂无信息哦 ！</div>
    @endif
    <div class="space-20"></div>
    @if(count($my_tasks) && $my_tasks['total'] && !is_null($my_tasks['next_page_url']))
    <div class="dataTables_paginate paging_bootstrap">
        <ul class="pagination">
            @if(!is_null($my_tasks['prev_page_url']))
                <li><a href="{{ $my_tasks['prev_page_url'] }}">&lt;</a></li>
            @endif
            @if($my_tasks['last_page']>1)
                @for($i=1;$i<=$my_tasks['last_page'];$i++)
                    <li class="{{ ($i==$my_tasks['current_page'])?'active':'' }}"><a href="{{ 'acceptTasksList?page='.$i }}" class="bg-blue">{{ $i }}</a></li>
                @endfor
            @endif
            @if(!is_null($my_tasks['next_page_url']))
                <li><a href="{{ $my_tasks['next_page_url'] }}">&gt;</a></li>
            @endif
        </ul>
    </div>
    @endif
</div>

{!! Theme::asset()->container('custom-css')->usepath()->add('messages','css/usercenter/messages/messages.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('usercenter','css/usercenter/usercenter.css') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('nopie','js/doc/nopie.js') !!}
@if($pie_data)
    {!! Theme::widget('mypie',['pie_data'=>$pie_data])->render() !!}
@endif
