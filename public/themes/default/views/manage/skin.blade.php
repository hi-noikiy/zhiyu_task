<div class="page-content-area">
    <div class="row">
        <div class="col-xs-12">
            {{--<div class="alert alert-info">
                <h3>模板标签</h3>
                <small>颜色选择</small>
            </div>--}}
            <h3 class="header smaller lighter blue mg-bottom20 mg-top12">模板标签<small>>>颜色选择</small></h3>
            <div id="skin" class="clearfix">
                <a href="/manage/skinSet/blue" id="skin_0" class="{{ ($skin_config=='blue')?'selected':'' }}" title="blue"></a>
                <a href="/manage/skinSet/red" id="skin_1" class="{{ ($skin_config=='red')?'selected':'' }}" title="red"></a>
                <a href="/manage/skinSet/gray" id="skin_2" class="{{ ($skin_config=='gray')?'selected':'' }}" title="gray"></a>
                <a href="/manage/skinSet/orange" id="skin_3" class="{{ ($skin_config=='orange')?'selected':'' }}" title="orange"></a>
            </div>
        </div>
    </div><!-- /.row -->
</div>

{!! Theme::asset()->container('custom-css')->usePath()->add('backstage', 'css/backstage/backstage.css') !!}
<script>
    $(function () {
        var aSkin = $("#skin a");  //查找到元素
        aSkin.click(function () {   //给元素添加事件
            switchSkin(this.id);//调用函数
        });
    });
    function switchSkin(skinName) {
        $("#" + skinName).addClass("selected")                //当前a元素选中
                .siblings().removeClass("selected");  //去掉其他同辈a元素的选中
    }
</script>