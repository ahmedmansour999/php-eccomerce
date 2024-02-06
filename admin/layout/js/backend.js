$(document).ready(function() {

    $('[placeholder]').focus(function(){
        $(this).attr("text-data" , $(this).attr("placeholder"))  ;
        $(this).attr("placeholder", "" ) ; 

    }).blur(function(){
        $(this).attr("placeholder", $(this).attr("text-data") ) ;

    })


})