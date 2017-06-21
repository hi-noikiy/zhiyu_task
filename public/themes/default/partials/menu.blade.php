
<div class="g-taskbarnav">
        <div class="container col-left">
            <div class="g-nav clearfix">
                <div class="pull-left hidden-xs">
                    <div class="g-tasknavdrop" id="nav"><i class="fa fa-reorder"></i>全部任务分类<i class="fa fa-exchange"></i>
                        <ul class="sub nav-dex text-left">
                            @if(!empty(Theme::get('task_cate')))
                                @if(count(Theme::get('task_cate')) >= 5)
                                    @for($j=0;$j<5;$j++)
                                        @if(isset(Theme::get('task_cate')[$j]['pid']) && Theme::get('task_cate')[$j]['pid'] == 0)
                                            <li>
                                                <div class="u-navitem">
                                                    <h4>
                                                        <a href="/task?category={!! Theme::get('task_cate')[$j]['id'] !!}" class="text-size14 cor-white">
                                                            {!! Theme::get('task_cate')[$j]['name'] !!}
                                                        </a>
                                                    </h4>
                                                    @if(!empty(Theme::get('task_cate')[$j]['child_task_cate']) && is_array(Theme::get('task_cate')[$j]['child_task_cate']))
                                                        @if(count(Theme::get('task_cate')[$j]['child_task_cate']) >= 3)
                                                            @for($i =0 ;$i<3;$i++)
                                                                <a href="/task?category={!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['id'] !!}" class="u-tit">
                                                                    {!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['name'] !!}
                                                                </a>
                                                            @endfor
                                                        @else
                                                            @for($i =0 ;$i<count(Theme::get('task_cate')[$j]['child_task_cate']);$i++)
                                                                <a href="/task?category={!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['id'] !!}" class="u-tit">
                                                                    {!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['name'] !!}
                                                                </a>
                                                            @endfor
                                                        @endif
                                                    @endif
                                                </div>
                                                @if(!empty(Theme::get('task_cate')[$j]['child_task_cate']) && is_array(Theme::get('task_cate')[$j]['child_task_cate']))
                                                    <div class="g-subshow">
                                                        <div>{!! Theme::get('task_cate')[$j]['name'] !!}</div>
                                                        <p>
                                                            @foreach(Theme::get('task_cate')[$j]['child_task_cate'] as $key => $val)
                                                                <a href="/task?category={!! $val['id'] !!}">{!! $val['name'] !!}</a>&nbsp;&nbsp;|&nbsp;@if(is_int(($key+1)/6)) @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                @endif
                                            </li>
                                        @endif
                                    @endfor
                                @else
                                    @for($j=0;$j<count(Theme::get('task_cate'));$j++)
                                        @if(isset(Theme::get('task_cate')[$j]['pid']) && Theme::get('task_cate')[$j]['pid'] == 0)
                                            <li>
                                                <div class="u-navitem">
                                                    <h4><a href="/task?category={!! Theme::get('task_cate')[$j]['id'] !!}" class="text-size14 cor-white">{!! Theme::get('task_cate')[$j]['name'] !!}</a></h4>
                                                    @if(!empty(Theme::get('task_cate')[$j]['child_task_cate']) && is_array(Theme::get('task_cate')[$j]['child_task_cate']))
                                                        @if(count(Theme::get('task_cate')[$j]['child_task_cate']) >= 3)
                                                            @for($i =0 ;$i<3;$i++)
                                                                <a href="/task?category={!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['id'] !!}" class="u-tit">{!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['name'] !!}</a>
                                                            @endfor
                                                        @else
                                                            @for($i =0 ;$i<count(Theme::get('task_cate')[$j]['child_task_cate']);$i++)
                                                                <a href="/task?category={!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['id'] !!}" class="u-tit">{!! Theme::get('task_cate')[$j]['child_task_cate'][$i]['name'] !!}</a>
                                                            @endfor
                                                        @endif
                                                    @endif
                                                </div>
                                                @if(!empty(Theme::get('task_cate')[$j]['child_task_cate']) && is_array(Theme::get('task_cate')[$j]['child_task_cate']))
                                                    <div class="g-subshow">
                                                        <div>{!! Theme::get('task_cate')[$j]['name'] !!}</div>
                                                        <p>
                                                            @foreach(Theme::get('task_cate')[$j]['child_task_cate'] as $key => $val)
                                                                <a href="/task?category={!! $val['id'] !!}">{!! $val['name'] !!}</a>&nbsp;&nbsp;|&nbsp;@if(is_int(($key+1)/6)) @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                @endif
                                            </li>
                                        @endif
                                    @endfor
                                @endif
                            @endif
                        </ul>
                    </div>
                    <div class="g-navList"><div class="g-navList-wrap clearfix">
                        @if(!empty(Theme::get('nav_list')))
                            @foreach(Theme::get('nav_list') as $m => $n)
                                @if($n['is_show'] == 1)
                                    <a href="{!! $n['link_url'] !!}" @if($n['is_new_window'] == 1)target="_blank" @endif @if(Theme::get('now_menu') == $n['link_url']) class="z-navHome" @endif>{!! $n['title'] !!}</a>
                                @endif
                            @endforeach
                        @else
                            <a href="{!! CommonClass::homePage() !!}" @if(CommonClass::homePage() == Theme::get('now_menu')) class="z-navHome" @endif>首页</a>
                            <a href="/task" @if('/task' == Theme::get('now_menu')) class="z-navHome" @endif>任务大厅</a>
                            <a href="/bre/service" @if('bre/service' == Theme::get('now_menu')) class="z-navHome" @endif>服务商</a>
                            <a href="/task/successCase" @if('/task/successCase' == Theme::get('now_menu')) class="z-navHome" @endif>成功案例</a>
                            <a href="/article" @if('/article' == Theme::get('now_menu')) class="z-navHome" @endif>资讯中心</a>
                        @endif
                    </div></div>
                </div>
                <div class="pull-right g-tasknavbtn visible-lg-block visible-md-block">
                    <a href="/task/create" class="u-ahref">发布需求</a>
                </div>
                <nav  class="navbar navbar-default navbar-static hidden-sm hidden-md hidden-lg col-xs-12"  id="navbar-example" role="navigation">
                    <div class="navbar-header">
                        <button class="navbar-toggle z-activeNavlist" type="button" data-toggle="collapse"
                                data-target=".bs-js-navbar-scrollspy">
                            <span class="sr-only">切换导航</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <button class="navbar-toggle mg-right0" type="button" data-toggle="collapse"
                                data-target=".bs-js-navbar-scrollspy1">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse bs-js-navbar-scrollspy">
                        <ul class="nav navbar-nav">
                            @if(!empty(Theme::get('nav_list')))
                                @foreach(Theme::get('nav_list') as $m => $n)
                                    @if($n['is_show'] == 1)
                                        <li>
                                            <a href="{!! $n['link_url'] !!}" @if($n['is_new_window'] == 1)target="_blank" @endif @if(Theme::get('now_menu') == $n['link_url']) class="z-navHome" @endif>{!! $n['title'] !!}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li>
                                    <a href="{!! CommonClass::homePage() !!}" @if(CommonClass::homePage() == Theme::get('now_menu')) class="z-navHome" @endif>首页</a>
                                </li>
                                <li>
                                    <a href="/task" @if('/task' == Theme::get('now_menu')) class="z-navHome" @endif>任务大厅</a>
                                </li>
                                <li>
                                    <a href="/bre/service" @if('bre/service' == Theme::get('now_menu')) class="z-navHome" @endif>服务商</a>
                                </li>
                                <li>
                                    <a href="/task/successCase" @if('/task/successCase' == Theme::get('now_menu')) class="z-navHome" @endif>成功案例</a>
                                </li>
                                <li>
                                    <a href="/article" @if('/article' == Theme::get('now_menu')) class="z-navHome" @endif>资讯中心</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse bs-js-navbar-scrollspy1 bg-white">
                        <ul class="nav navbar-nav clearfix">
                            <li class="clearfix">
                                <a href="javascript:;" class="clearfix search-btn">
                                    <div class="g-tasksearch clearfix">
                                        <i class="fa fa-search"></i>
                                        <input type="text" placeholder="输入关键词" class="input-boxshaw"/>
                                        <button>搜索</button>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>


