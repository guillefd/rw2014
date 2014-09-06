var rwform_alertbar_div = $("#rwform_alertbar");

$(document).ready(function(){  

 rwform_alertbar_div.hide();  
  
 //input filter action - keypress
 $("#submit").click(function() {
     $("#rwform_loader").remove();
     $("#rwform_ajximg").remove();     
     rwform_alertbar_div.html("");
     rwform_alertbar_div.hide();
     $("#submit").after(rwform_img_loader);
     doAjaxQuery(rwform_input, rwform_target);            
});

// schedule fields checker ::::::::::: 

$('#msg_schedule_1').change(function(){
    check_schedule_consistency('start');
}); 
    
$('#msg_schedule_2').change(function(){
    check_schedule_consistency('end');
});


function check_schedule_consistency(origin)
{
    start = Number( $('#msg_schedule_1').val() );
    end = Number( $('#msg_schedule_2').val() );   
    dif =  end - start; 
    if( dif < 1 )
    {
        if(origin == 'start')
        {
            value = start + 2;
            $('#msg_schedule_2').val(value);    
        }
        else
        {
            value = end - 2;
            $('#msg_schedule_1').val(value);               
        }
    }
}

// schedule fields checker ::::::::::: 

function reset_form()
{
    $('#msg_startdate').val('');
    $('#msg_enddate').val('');
    $('select[name="subject"]').val('');
    $('select[name="msg_schedule_1"]').val('9'); 
    $('select[name="msg_schedule_2"]').val('13');        
    $('select[name="msg_hours"]').val('3');
    $('select[name="msg_totdays"]').val('1');
    $('select[name="msg_pax"]').val('1-5');             
    $('textarea[name="msg_comments"]').val('');
    $('select[name="captcha"]').val('-1');       
}
  
function doAjaxQuery(input, link)
{
    var form_data = $('#formE').serialize();

    $.ajax({
        type: "POST",
        url: link,
        data: form_data,
        dataType: 'json',
        success: function(result){
            rwform_alertbar_div.attr("class","alert");
            rwform_alertbar_div.show();
            rwform_alertbar_div.addClass(result.cssclass);
            rwform_alertbar_div.html(result.message);
            $("#rwform_loader").remove();            
            if(result.response == "OK")
            {    
                $("#submit").after(rwform_img_ok);
                reset_form();                         
            }
            if(result.response == "ERROR")
            {
                $("#submit").after(rwform_img_error);      
            }
        },
        error: function()
        {
            $('#rwform_loader').remove(); 
            rwform_alertbar_div.show();            
            rwform_alertbar_div.addClass('alert alert-danger');            
            rwform_alertbar_div.html('Hay un problema de conexión, vuelva a intentarlo.');
            $("#submit").after(rwform_img_error);             
        }
    });         
}
    
});