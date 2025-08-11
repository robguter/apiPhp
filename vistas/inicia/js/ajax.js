
$(document).ready(function(){
    $("input[name='bProy']").click(function(){
        if(($(this).val())) {
            $("button#Envia").prop("disabled", false);
        }
    });
    
    $("input[type='text']").on("keyup", function(){
        if( $(this).val() && $("input[type='password']").val() ) {
            $("button#Envia").prop("disabled", false);
        }
    });
    
    $("input[type='password']").on("keyup", function(){
        if( $(this).val() && $("input[type='text']").val() ) {
            $("button#Envia").prop("disabled", false);
        }
    });
    
});