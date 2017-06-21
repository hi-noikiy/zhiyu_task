{{--列表--}}
<h3 class="header smaller lighter blue mg-bottom20 mg-top12">问答管理</h3>

<div class="well">
    <form class="form-inline search-group" role="form" action="http://kppw31.io/manage/userFinance" method="get">
        <div class="form-group search-list width285">
            <label for="name" class="">提问人　</label>
            <input type="text" name="username" value="">
        </div>
        <div class="form-group search-list width285">
            <label for="namee" class="">提问类型　</label>
            <select name="first_category">
                @foreach($category_first as $v)
                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                @endforeach
            </select>
            <select name="second_category" id="">
                @foreach($category_second as $v)
                <option value="{{ $v['id'] }}">{{ $v['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm">搜索</button>
        </div>
        <div class="space"></div>
        <div class="form-group search-list width285">
            <label for="namee" class="">状态　　</label>
            <select name="status" >
                @foreach($map as $k=>$v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group  ">
            <select name="time_type">
                <option value="1">发布时间</option>
                <option value="2">审核时间</option>
            </select>
            <div class="input-daterange input-group">
                <input type="text" name="start" class="input-sm form-control" value="">
                <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                <input type="text" name="end" class="input-sm form-control" value="">
            </div>
        </div>
        <div class="">

        </div>
    </form>
</div>

<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>

            </th>
            <th>
                <label>
                    编号
                </label>
            </th>
            <th>提问人</th>
            <th>提问类型</th>

            <th>
                发布时间
            </th>
            <th>审核时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        @foreach($question as $v)
        <tr>
            <td class="center">
                <label class="">
                    <input type="checkbox" class="ace" name="chk">
                    <span class="lbl"></span>
                </label>
            </td>
            <td>{{ $v['id'] }}</td>
            <td>{{ $v['username'] }}</td>
            <td>{{ $v['question_category'] }}</td>
            <td>{{ $v['time'] }}</td>
            <td>{{ $v['verify_at'] }}</td>
            <td>
                @if($v['status']==1)
                <span class="label label-sm label-warning">待审核</span>
                @elseif($v['status']==5)
                <span class="label label-sm label-danger">审核失败</span>
                @else
                <span class="label label-sm label-success">已审核</span>
                @endif
            </td>
            <td>
                @if($v['status']==1)
                <a class="btn btn-xs btn-success" href="{{ URL('manage/verify',['id'=>$v['id'],'status'=>1]) }}">
                    <i class="ace-icon fa fa-check bigger-120"></i>审核成功
                </a>
                <a class="btn btn-xs btn-danger" href="{{ URL('manage/verify',['id'=>$v['id'],'status'=>2]) }}">
                    <i class="ace-icon fa fa-ban bigger-120"></i>审核失败
                </a>
                @endif
                <a class="btn btn-xs btn-warning" href="{{ URL('manage/getDetail',['id'=>$v['id']]) }}">
                    <i class="ace-icon fa fa-search bigger-120"></i>查看
                </a>
                <a class="btn btn-xs btn-danger" href="{{ URL('manage/questionDelete',['id'=>$v['id']]) }}">
                    <i class="ace-icon fa fa-trash-o bigger-120"></i>删除
                </a>
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="dataTables_paginate paging_bootstrap row">
            {!! $question->appends($_GET)->render() !!}
        </div>
    </div>
</div>

{!! Theme::asset()->container('custom-css')->usepath()->add('backstage', 'css/backstage/backstage.css') !!}
{!! Theme::asset()->container('specific-css')->usePath()->add('datepicker-css', 'plugins/ace/css/datepicker.css') !!}
{!! Theme::asset()->container('specific-js')->usePath()->add('datepicker-js', 'plugins/ace/js/date-time/bootstrap-datepicker.min.js') !!}
{!! Theme::asset()->container('custom-js')->usePath()->add('userfinance-js', 'js/userfinance.js') !!}