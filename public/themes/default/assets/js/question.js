/**
 * Created by Administrator on 2016/10/10 0010.
 */

$(function(){
    $('#pid').change(
        function(){
           var i= $('#pid').val();
           $.get('child/' + i, function(msg){
               $('#child').children('option').remove();
                  for(var a=0;a<msg.length;a++){
                        $('#child').append("<option value="+msg[a].id+">"+msg[a].name+"</option>");
                  }
               },'json'
           )
        }
    )
})