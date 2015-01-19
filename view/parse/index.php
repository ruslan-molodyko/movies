<script>
$(document).ready(function() {
    $('#sendfile').click(function() {
        var A=$("#imageloadstatus");
        var B=$("#imageloadbutton");

        $("#send_file_form").ajaxForm({target: '#preview',
            beforeSubmit:function(){
                A.show();
                B.hide();
            },
            success:function(){
                A.hide();
                B.show();
            },
            error:function(){
                A.hide();
                B.show();
            }
        }).submit();
    });
});
</script>
<div class="menu-title">Загрузить файл</div>
<div id='preview' style="text-align: center;padding: 10px;">
</div>
<form id="send_file_form" method="post" enctype="multipart/form-data" action='?controller=parse&action=upload' style="clear:both">

<div id='imageloadstatus' style='display:none;text-align: center;margin-top: 10px;'>
<div>Подождите файл загружается</div>
<div style="margin-top: 10px;text-align: center;"><img src="public/css/images/loader.gif" alt="Uploading...."/></div>

</div>

<div id='imageloadbutton' style="text-align: center;margin-top: 15px;">
<input type="file" name="file" id="file_input" multiple="true" />
<div style="text-align: center;margin-top: 15px;"><input type="button" id="sendfile" value="Загрузить файл"></div>
</div>

</form>