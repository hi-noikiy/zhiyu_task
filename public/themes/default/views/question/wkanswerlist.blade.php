
<div class="container">
    <div class="row">
        <div class="col-md-12 col-left">
            <!-- 所在位置 -->
            <div class="now-position text-size12">
                您的位置：首页 > 问答中心 > 我要回答
            </div>
        </div>
    </div>
    <div class="row">
        <!-- main -->
        <div class="col-lg-9 col-left">
            <div class="news-main-area question-left reply no-margin-bottom">
                <div class="news-detail-info clearfix">
                    <div class="page-header">
                        <h4 class="text-size20 cor-gray51 mg-margin ">
                            <span class=" badgee">问</span>
                            <span class="mg-left30">{{$question['discription']}}？</span>
                        </h4>
                        <div class="change-cp cor-gray89">
                            <a href="javascript:;">{{$question['username']}}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<span>{{$question['name']}}</span>&nbsp;&nbsp;|&nbsp;&nbsp;<span> {{$question['time']}}2016-09-22</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>问题将于2016-01-04日  23:11:11  结束</span>
                            {{--分享--}}
                            <div class="bdsharebuttonbox clearfix" data-tag="share_1">
                                <div class="shop-sharewrap"><span class="pull-left cor-gray51">分享：&nbsp;</span>
                                    <!-- JiaThis Button BEGIN -->
                                    <div class="jiathis_style">
                                        <a class="jiathis_button_tsina"></a>
                                        <a class="jiathis_button_weixin"></a>
                                        <a class="jiathis_button_qzone"></a>
                                        <a class="jiathis_button_tqq"></a>
                                        <a class="jiathis_button_cqq"></a>
                                        <a class="jiathis_button_douban"></a>
                                    </div>
                                    <script type="text/javascript" >
                                        var jiathis_config={
                                            summary:"",
                                            shortUrl:false,
                                            hideMore:false
                                        }
                                    </script>
                                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                                    <!-- JiaThis Button END --></div>
                                <div class="shop-share"></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-2"></div>
                    <p><a class="text-size14" data-toggle="collapse" data-target=".wkanlistshow" href="javascript:;">我要回答>></a></p>
                    <div class="space-6"></div>
                    <form action="/question/answeradd" id="form" method="post" >
                        <div class="clearfix wkanlistshow collapse">
                            <script id="editor" name="desc" type="text/plain" style="height:300px;"></script>
                            <div class="space-4"></div>
                            <input type="hidden" name="desc" id="discription-edit" datatype="*1-1000" nullmsg="描述不能为空" errormsg="字数超过限制" >
                            <span class="Validform_checktip"><span class="cor-orange"><i class="fa fa-exclamation-circle"></i> 长度不超过1000个字符</span></span>
                            <div class="pull-right">
                                <div class="space-4"></div>
                                <button form="form" class="btn btn-primary btn-sm btn-big1 btn-blue bor-radius2 " id="subTask">提交回答</button>
                            </div>
                            <div class="space-20"></div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="questionid" value="{{$question['id']}}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="space-10"></div>
            {{--采纳状态--}}
            <div class="answerlist-main news-main-area news-detail-info question-icobg">
                <div class="ico-111"></div>
                <div class="ico-112"></div>
                <ul>
                    <li class="row">
                        <div class="col-sm-1 col-xs-2 usercter answerlist-img">
                            <img src="/themes/default/assets/images/news_pic_side.png" alt="">
                        </div>
                        <div class="col-sm-11 col-xs-10 usernopd">
                            <div class="cor-gray51 text-size14">滂沱de蚂蚁root</div>
                            <div class="space-2"></div>
                            <p class="cor-gray89 text-size12">2016-10-13 15:40:41 提交于   2016-09-08    14:21:11</p>
                            <div class="space-2"></div>
                            <div class="cor-gray51 text-size14 answerlist-cont"><p>sdfsdfdfsdf<img src="/ueditor/php/upload/image/20161013/1476344438728183.jpg" title="1476344438728183.jpg" alt="ceshitu.jpg"></p>
                            </div>
                            <div class="clearfix">
                                <a href="javascript:;" class="cor-orange pull-right answerlist-clickups"><i class="fa fa-database text-size14"></i> <span class="answerlist-addnum" style="display: inline-block;">10</span><span class="answerlist-addzan" style="display: none;">去打赏</span><span class="answerlist-add">+1</span></a>
                                <a href="javascript:;" class="cor-blue2f pull-right answerlist-clickup" style="margin-right: 10px"><i class="fa fa-thumbs-up text-size14"></i> <span class="answerlist-addnum" style="display: inline-block;">100</span><span class="answerlist-addzan" style="display: none;">赞</span><span class="answerlist-add">+1</span></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="space-10"></div>
            {{--全部回答--}}
            {{--<div class="answerlist-main news-main-area news-detail-info">
                <div class="space-8"></div>
                <div class="cor-gray51 text-size16 answerlist-head">全部回答（{{$count}}）</div>
                <div class="space"></div>
                <ul>
                    @foreach($answer as $k => $v)
                    <li class="row">
                        <div class="col-sm-1 col-xs-2 usercter answerlist-img">
                            @if(!empty($v['avatar']))
                            <img src="{{$v['avatar']}}" alt="">
                              @else
                                <img src="{!! Theme::asset()->url('images/news_pic_side.png') !!}" alt="">
                            @endif
                        </div>
                        <div class="col-sm-11 col-xs-10 usernopd">
                            <div class="cor-gray51 text-size14">{{$v['username']}}</div>
                            <!--答案的用户id-->
                            <input type="hidden" name="answeruid" value="{{$v['answeruid']}}"/>
                            <!--登陆用户的id-->
                            <input type="hidden" name="uid" value="{{$uid}}"/>
                            <div class="space-2"></div>
                            <p class="cor-gray89 text-size12">{{$v['time']}} 提交于   2016-09-08    14:21:11</p>
                            <div class="space-2"></div>
                            <div class="cor-gray51 text-size14 answerlist-cont">{!! htmlspecialchars_decode($v['content']) !!}
                                --}}{{--}因为你所买卖的产品说不准连正真许可证都没有，因为你所谓的微商就是骗钱间接的传销行为，因为微信朋友圈qq空间说说全是你的所谓广告，谁都反感，至少我特别讨厌--}}{{--
                            </div>
                            <div class="clearfix">
                                <a href="javascript:;" class="cor-blue2f pull-right answerlist-clickup" ><i class="fa fa-thumbs-up text-size14"></i>  <input type="hidden" type="answer" value="{{$v['id']}}"/><span class="answerlist-addnum" id="num">{{$v['praisenum']}}</span><span class="answerlist-addzan">赞</span><span class="answerlist-add">+1</span></a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>--}}
        </div>
        <!-- side -->
        <div class="col-md-3 g-taskside visible-lg-block col-left">
            <div class="g-tasksidemand">

                {{--@if(count($rightAd))
                    <a href="{!! $rightAd[0]['ad_url'] !!}"><img src="{!! URL($rightAd[0]['ad_file']) !!}" alt=""></a>
                @else--}}
                    <img src="{!! Theme::asset()->url('images/news_pic_side.png') !!}" alt="">
               {{-- @endif--}}
            </div>

        </div>
    </div>
    <div class="space-30"></div>
</div>
{!! Theme::asset()->container('custom-css')->usepath()->add('messages','css/usercenter/messages/messages.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('news','css/news.css') !!}
{!! Theme::asset()->container('custom-css')->usepath()->add('question','css/question.css') !!}
{!! Theme::widget('ueditor')->render() !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('reply', 'js/reply.js') !!}
{!! Theme::asset()->container('specific-js')->usepath()->add('validform-js','plugins/jquery/validform/js/Validform_v5.3.2_min.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('answerlist', 'js/answerlist.js') !!}
{!! Theme::asset()->container('custom-js')->usepath()->add('praise', 'js/praise.js') !!}