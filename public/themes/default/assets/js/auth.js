/**
 * Created by kuke on 2016/4/26.
 */
var register = $(".registerform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
    ajaxPost:false,
});

register.eq(0).config({
    ajaxurl:{
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }
});

register.eq(1).config({
    ajaxurl:{
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }
});

function clearspecial(inputobj){
    inputobj.value = inputobj.value.replace(/[^a-z\d\u4e00-\u9fa5]/ig, '');
}


