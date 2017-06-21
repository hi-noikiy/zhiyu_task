/**
 * Created by kuke on 2016/4/27.
 */
var passwordform = $(".passwordform").Validform({
    tiptype:4,
    label:".label",
    showAllError:true,
    datatype:{
        "e":/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    },
});

passwordform.eq(0).config({
    ajaxurl:{
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }
});
passwordform.eq(1).config({
    ajaxurl:{
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }
});