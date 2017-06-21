
    <div class="g-taskposition col-md-12">
            您的位置：首页 > 任务大厅
    </div>

    <div class="col-xs-12 hidden-xs">
        <div class="poster">
            <div data-target="#step-container" class="row-fluid" id="fuelux-wizard">
                <ul class="wizard-steps">
                    <li class="active" data-target="#step1">
                        <span class="title h6 p-space">需求描述</span>
                        <span class="step">1</span>
                    </li>
                    <li data-target="#step2">
                        <span class="title h6 p-space">交易模式</span>
                        <span class="step">2</span>
                    </li>
                    <li data-target="#step3">
                        <span class="title h6 p-space">确认需求，托管赏金</span>
                        <span class="step">3</span>
                    </li>
                    <li data-target="#step4">
                        <span class="title h6 p-spaces">等待审核</span>
                        <span class="step">4</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="col-lg-9 list-l ">
            <form action="/task/createTask" method="post" id="form" enctype="multipart/form-data">
                {!! csrf_field() !!}
            <div class="row">
                <div class="task-r">
                    <ul class="mg-margin">
                        <li>
                            <a class="task-tit" href="javascript:;" data-toggle="collapse" data-target="#demo">
                                <span class="ace-icon fa fa-angle-double-down bigger-110" data-icon-hide="ace-icon fa fa-angle-double-down" data-icon-show="ace-icon fa fa fa-angle-double-right"></span> 描述需求
                            </a>
                            <div id="demo" class="collapse in">

                                <div class="form-group task-phone">
                                    <label for="name" class="phone">联系手机：</label>
                                    <input type="text" class="form-control task-input" id="name"  name="phone"  value="{!! old('phone') !!}{{ !empty($_GET['phone'])?$_GET['phone']:'' }}{{ $task->phone }}" placeholder="请输入手机号" datatype="n" nullmsg="请填写手机号！" errormsg="手机号错误！">
                                    @if($errors->first('phone'))
                                    <span class="Validform_checktip Validform_wrong">{!! $errors->first('phone') !!}</span>
                                    @endif
                                </div>
                                {{--<div class="task-select" id="task-select">--}}
                                    {{--<p class="text-blod">选择需要做什么：</p>--}}
                                    {{--@foreach($hotcate as $v)--}}
                                        {{--<a url="{{ URl('task/getTemplate') }}" cate-id="{{ $v['id'] }}" onclick="chooseCate($(this));" >{{ $v['name'] }}</a>--}}
                                    {{--@endforeach--}}
                                    {{--<span><a class="select-txt z-close" href="javascript:;">更多>></a></span>--}}
                                    {{--@if($errors->first('cate_id'))--}}
                                    {{--<p class="Validform_checktip Validform_wrong">{!! $errors->first('cate_id') !!}</p>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                <div class="task-select1" id="gd"  style="margin-bottom: 0px;">
                                    <p class="text-blod">选择需要做什么：</p>
                                    <select multiple="" class="chosen-select tag-input-style"  name="cate_id"  data-placeholder="选择一下您的标签吧" style="display:block;">
                                        @foreach($category_all as $v)
                                        <option value="{{ $v['id'] }}" cate-id="{{ $v['id'] }}" {{ ($task['cate_id']==$v['id'])?'selected':'' }} onclick="chooseCate($(this));" >{{ $v['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom: 39px;">
                                    <input type="hidden" name="cate_id" id="task_category" value="{{ $task['cate_id'] }}"  datatype="n" nullmsg="请选择需要做什么！" />
                                </div>
                                <div class="task-bar">
                                    <p>地域：</p>
                                    <a class="area-limit {{ ($task['region_limit']==0)?'':'bar-txt' }}" href="javascript:void(0);">不限地区</a>
                                    <a class="area-limit {{ ($task['region_limit']==1)?'':'bar-txt' }}" href="javascript:void(0);">指定地区</a>
                                    <span id="area_select" style="{{ ($task['region_limit']==1)?'':'display:none' }}">
                                        <select name="province" style="margin-left:20px;" onchange="checkprovince(this)">
                                            @foreach($province as $v)
                                                <option value={{ $v['id'] }}>{{ $v['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <select name="city" id="province_check" onchange="checkcity(this)">
                                            @foreach($city as $v)
                                                <option value={{ $v['id'] }}>{{ $v['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <select name="area" id="area_check" onchange="arealimit(this)">
                                            @foreach($area as $v)
                                                <option value={{ $v['id'] }}>{{ $v['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </span>

                                    <input type="hidden" name="area" id="region-limit" value="0" />
                                </div>
                                <div class="form-group">
                                    <p class="text-blod">明确需求标题和详情：</p>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" class="col-xs-10 col-sm-5" name="title" value="{!! old('title') !!}{{ !empty($_GET['title'])?$_GET['title']:'' }}{{ $task->title }}" id="form-input-readonly" placeholder="一句话描述您的需求，XX餐饮公司VI设计" datatype="*" nullmsg="请填写标题！">
                                        <span class="help-inline col-xs-12 col-sm-7">
                                            <label class="middle">
                                                <span class="lbl" id="example"><a href="javascript:;">参照发布实例</a></span>
                                                <span class="lbl txt-lbl"><a href="/task">逛任务大厅看看别人怎么写</a></span>
                                            </label>
                                        </span>
                                        @if($errors->first('title'))
                                            <p class="Validform_checktip Validform_wrong">{!! $errors->first('title') !!}</p>
                                        @endif
                                        </div>

                                        <!-- 模态框（Modal） -->
                                        <div class="modal fade" id="myexample" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color:#e4e4e4;">
                                                        <button type="button" class="close" data-dismiss="modal" id="model-close" aria-hidden="true">
                                                            &times;
                                                        </button>
                                                        <h5 class="modal-title" id="myModalLabel"><b>选择您的模板</b></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="myTabContent" class="tab-content">
                                                            <div class="tab-pane fade in active">
                                                                <h4 class="text-center" id="template-title">请先选择您需要做什么</h4>
                                                                <div id="template-content">

                                                                </div>
                                                            </div>
                                                            <div class="text-center">
                                                                <button type="button" onclick="insert_example()" class="btn btn-primary" data-toggle="button">插入模板</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div>
                                        </div><!-- 模态框（Modal）end -->
                                    </div>
                                </div>
                                <!--编辑器-->
                                <div class="clearfix">
                                    <script id="editor"  type="text/plain" style="height:300px;">{!! htmlspecialchars_decode($task['desc']) !!}</script>
                                    <div style="display:none;">
                                    <input type="hidden" name="description" id="discription-edit"  value="{!! old('description') !!}{{ $task['desc'] }}" datatype="*1-5000" nullmsg="需求描述不能为空" errormsg="字数超过限制">
                                    </div>
                                    @if($errors->first('description'))
                                        <p class="Validform_checktip Validform_wrong">{!! $errors->first('description') !!}</p>
                                    @endif
                                </div>


                                <div class="annex">
                                    <!--文件上传-->
                                    <div action="../dummy.html" class="dropzone clearfix" id="dropzone"  url="{{ URL('task/fileUpload')}}">
                                        @foreach($task_attachment_data as $v)
                                        <div class="dz-preview dz-processing dz-image-preview dz-success">
                                            <div class="dz-details">
                                                <div class="dz-filename"><span data-dz-name="">{{ $v['name'] }}</span></div>
                                                <div class="dz-size" data-dz-size=""><strong>{{ $v['size'] }}</strong> MB</div>
                                                @if(matchImg($v['type'])=='img')
                                                <img data-dz-thumbnail src="{{ $domain.'/'.$v['url'] }}" alt="{{ $v['name'] }}">
                                                @endif
                                                {{--<span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>--}}
                                            </div>
                                            <div class="dz-success-mark"><span>✔</span></div>
                                            <div class="dz-error-mark"><span>✘</span></div>
                                            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                                            <a class="dz-remove" href="javascript:viod(0);" onclick="deletefile($(this))" attachment_id="{{ $v['id'] }}" data-dz-remove>删除文件</a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div id="file_update">
                                    @foreach($task_attachment_data as $v)
                                        <input type='hidden'  name='file_id[]' id='file-{{ $v['id'] }}' value='{{ $v['id'] }}'/>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="task-tit" href="javascript:;" data-toggle="collapse" data-target="#demol">
                                <span class="ace-icon fa fa-angle-double-down bigger-110" data-icon-hide="ace-icon fa fa-angle-double-down" data-icon-show="ace-icon fa fa fa-angle-double-right"></span> 交易模式
                            </a>
                            <div id="demol" class="collapse in">
                                <div class="checkbox">
                                    <label class="z-check">
                                        <input  type="checkbox" class="ace" name="xuanshang" checked >
                                        <span class="lbl text-blod text-size16" data-toggle="collapse" data-target="#ck"> 悬赏模式</span>
                                    </label>
                                </div>
                                <!--<p class="mission-tit text-size16 text-blod"><i class="fa fa-check"></i> 悬赏模式</p>-->
                                <div class=" mission-task">
                                    <p>威客们先工作，再选中标作品。托管赏金后吸引更多威客。</p>
                                    <div class="collapse in" id="ck">
                                        <div class="mission-ck ">
                                            <div class="checkbox ">
                                                <label class="checkbox-inline">
                                                    有明确预算，明确的预算更能吸引服务商参与
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="bounty" id="bounty" value="{!! old('bounty') !!}{{ $task['bounty'] }}" class="mis-txt" ajaxurl="/task/checkbounty" datatype="decimal"  nullmsg="请填写你的预算！" errormsg="请填写数子,最多保留两位小数！" >

                                                @if($errors->first('bounty'))
                                                    <p class="Validform_checktip Validform_wrong"> {!! $errors->first('bounty') !!}</p>
                                                @endif
                                            </div>
                                            <div class="checkbox ">
                                                <label class="checkbox-inline">
                                                    希望有多少服务商完成此任务？
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" name="worker_num" class="mis-txt" value="{!! old('worker_num') !!}{{ $task['worker_num'] }}" datatype="n"  nullmsg="请填写服务商数量！" errormsg="请填写数字！">
                                                @if($errors->first('worker_num'))
                                                    <p class="Validform_checktip Validform_wrong">{!! $errors->first('worker_num') !!}</p>
                                                @endif
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    您需要何时完成？
                                                </label>
                                            </div>
                                            <div class="input-daterange input-group" style="width:90%;margin-left:20px;">
                                            <span class="input-group-addon date-icon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                                <input type="text" class="input-sm form-control datepicker" id="datepiker-begin" onchange="beginAt($(this))"  value="{!! old('start') !!}"  placeholder="开始时间" >
                                            <span class="input-group-addon  date-icon ">
                                                <i class="fa fa-exchange"></i>
                                            </span>
                                                <input type="text" class="input-sm form-control datepicker" id="datepiker-deadline" onchange="deadline($(this))"  value="{!! old('delivery_deadline') !!}"  placeholder="结束时间">
                                            </div>
                                            @if($errors->first('start')|| $errors->first('delivery_deadline') )
                                                <p class="Validform_checktip Validform_wrong">
                                                    {!! $errors->first('start') !!}
                                                    {!! $errors->first('delivery_deadline') !!}
                                                </p>
                                            @endif
                                            <input name="type_id" type="hidden" value="{{ $rewardModel['id'] }}" />
                                            <input name="begin_at" type="hidden" value="{!! old('start') !!}" id="begin_at" datatype="*" nullmsg="请填写开始时间！" />
                                            <input name="delivery_deadline" value="{!! old('delivery_deadline') !!}"  type="hidden" id="delivery_deadline" ajaxurl="/task/checkdeadline"  datatype="*" nullmsg="请填写截稿时间！"  />
                                            <span class="validform_checktip  Validform_wrong" style="width:90%;margin-left:20px;display:none"> sss</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="task-tit" href="javascript:;" data-toggle="collapse" data-target="#demor">
                                <span class="ace-icon fa fa-angle-double-{{ (!empty(old('product')) || !empty($task_service_ids))?'down':'right' }} bigger-110" data-icon-hide="ace-icon fa fa-angle-double-down" data-icon-show="ace-icon fa fa fa-angle-double-right"></span> 增值服务
                            </a>
                            <div id="demor" class="collapse {{ (!empty(old('product')) || !empty($task_service_ids))?'in':'' }}">
                                <ul class="vat">
                                    @foreach($service as $v)
                                        <li class="clearfix">
                                            <div class="pull-left">
                                                <div class="checkbox pull-left">
                                                    <label>
                                                        <input type="checkbox" name="product[]" {{ ((!empty(old('product')) && in_array($v['id'],old('product'))) || (!empty($task_service_ids) && in_array($v['id'],$task_service_ids)) )?'checked':'' }} class="taskservice" price="{{ $v['price'] }}" value={{ $v['id'] }}><span class=" {{ ((!empty(old('product')) && in_array($v['id'],old('product'))) || (!empty($task_service_ids) && in_array($v['id'],$task_service_ids)) )?'z-sp2':'' }}">{{ substr($v['title'],0,3) }}</span>
                                                    </label>
                                                </div>
                                                <div class="pull-left">
                                                    <p>{{ $v['title'] }}</p>
                                                    <p>{{ $v['description'] }}</p>
                                                </div>
                                            </div>
                                            <div class="pull-right vat-txt">
                                                ￥{{ $v['price'] }}
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="clearfix">
                                        <div class="checkbox pull-left">
                                            <label>
                                                <input type="checkbox"><span class="vat-check">全选</span>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="task-bt">
                    <h3><strong>结算清单</strong></h3>
                    <p>托管赏金：<span>￥<span id="bounty_money">{{ $task['bounty'] }}<span></span></p>
                    <div style="{{ in_array($v['id'],$task_service_ids)?'':'display:none' }}" id="service-box">
                        <p>增值服务：</p>
                        @foreach($service as $v)
                            <p class="bt-pd" style=" {{ in_array($v['id'],$task_service_ids)?'':'display:none' }}" id="service-{{ $v['id'] }}">{{ $v['title'] }}：<span>￥{{ $v['price'] }}</span></p>
                        @endforeach
                    </div>
                    <p>应付总额 <span>￥<span id="total-price">{{ ($task['bounty']+$task_service_money) }}</span></span></p>
                    <input type='hidden' name="slutype" value="1" id="slutype"/>
                    <button class="btn btn-primary btn-blue bor-radius2 btn-big1" onclick="sluSub(1)">保存</button><a href="javascript:sluSub(2);"  class="text-size14">预览任务</a><a href="javascript:sluSub(3);" class="text-size14">暂不发布</a>
                </div>
            </div>
            </form>
        </div>
        <div class="col-lg-3 task-l hidden-xs hidden-md hidden-sm">
            <div class="taskside">
                <p class="text-center text-size14 cor-gray51 ">遇到问题，联系客服免费帮您解决</p>
                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1140756247&site=qq&menu=yes"  class="btn btn-block btn-primary bor-radius2 text-size14 btn-blue">联系在线客服</a>
                <div class="space"></div>
                <div class="iss-ico1">
                    <p class="cor-gray51 mg-margin">全国免长途电话：</p>
                    <p class="text-size20 cor-gray51">400-899-259</p>
                </div>
                <div class="iss-ico2">
                    <p class="cor-gray51 mg-margin">企业QQ：</p>
                    <p class="text-size20 cor-gray51">1140756247</p>
                </div>
            </div>
            <div class="taskside1">
                <img src="{{ Theme::asset()->url('images/task-gg.png') }}" alt="" class="img-responsive" width="100%">
            </div>
        </div>
    </div>

    {!! Theme::asset()->container('custom-css')->usepath()->add('issuetask','css/taskbar/issuetask.css') !!}s
    {!! Theme::asset()->container('specific-css')->usepath()->add('chossen','css/ace/chosen.css') !!}
    {{--{!! Theme::asset()->container('custom-js')->usepath()->add('ace-extra', 'plugins/ace/js/ace/ace-extra.min.js') !!}--}}

    {!! Theme::asset()->container('custom-js')->usepath()->add('chosen', 'plugins/ace/js/chosen.jquery.min.js') !!}
    {{--{!! Theme::widget('ueditor',['plugins'=>CommonClass::getEditorInit(['insertImage'])])->render() !!}--}}
    {!! Theme::widget('ueditor')->render() !!}
    {!! Theme::widget('datepicker')->render() !!}
    {!! Theme::widget('fileUpload',['maxFiles'=>(3-count($task_attachment_data))])->render() !!}
    {!! Theme::asset()->container('custom-js')->usepath()->add('task', 'js/doc/release.js') !!}
            <!--日历 有可能是手机端的，暂时不能删除-->
    {{--{!! Theme::asset()->container('custom-js')->usepath()->add('custom', 'plugins/ace/js/jquery-ui.custom.min.js') !!}--}}
    {{--{!! Theme::asset()->container('custom-js')->usepath()->add('touch-punch', 'plugins/ace/js/jquery.ui.touch-punch.min.js') !!}--}}

    {!! Theme::asset()->container('specific-css')->usepath()->add('validform-css','plugins/jquery/validform/css/style.css') !!}
    {!! Theme::asset()->container('specific-js')->usepath()->add('validform-js','plugins/jquery/validform/js/Validform_v5.3.2_min.js') !!}