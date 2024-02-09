$(document).ready(function() {

    $('[placeholder]').focus(function(){
        $(this).attr("text-data" , $(this).attr("placeholder"))  ;
        $(this).attr("placeholder", "" ) ; 

    }).blur(function(){
        $(this).attr("placeholder", $(this).attr("text-data") ) ;

    })


    // add * to required attributes

    // $('input').each(function(){
    //     if ($(this).attr('required') === 'required') {
    //         $(this).after('<span class="asterisk">*</span>');
    //         $(this).css('background-color', 'red');
    //     }
    // });
    
    
})