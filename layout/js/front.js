$(document).ready(function () {
  $("[placeholder]")
    .focus(function () {
      $(this).attr("text-data", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("text-data"));
    });



    /*
      -Show more 
      _Show Less
    */
      $(document).on('click', '.card-header .toggleSpan', function() {
        $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
        if ($(this).hasClass('selected')) {
            $(this).html('<i class="fas fa-minus toggle"></i>');
        } else {
            $(this).html('<i class="fas fa-plus toggle"></i>');
        }
      });


  // /*
  //   add * to required attributes
  // */

  //   $("input").blur(function () {
  //     if ($(this).val().trim() === "") {
  //         $(this).after('<span class="asterisk">*Required</span>');
  //         $(this).css("background-color", "red");
  //     }
  // }).keypress(function(){
  //     // Remove asterisk if user starts typing
  //     $(this).next('.asterisk').remove();
  //     $(this).css("background-color", "#EEE");
  // });

  
  /*
    Confirm Delete 
  */

  $(".confirm").click(function () {
    return confirm("Are you sure ? ");
  });



  /*
      show password
  */

  var passField = $(".password");

  $(".show-pass").click(function () {
    var passField = $(".password");
    if (passField.attr("type") === "password") {
      passField.attr("type", "text");
    } else {
      passField.attr("type", "password");
    }
  });



  $(".cat .head").click(function() {    
    $(this).next(".cat .body").fadeToggle(100); 

  });
  




  $('.view a').click(function() {
    $(this).addClass('active').siblings('a').removeClass('active') ;
    if ($(this).data('view') == "full") {
      $(".cat .body").fadeIn(100);
    } else{
      $('.cat .body').fadeOut(100);
    }
  })





// front end 

/*
    - login page (Login | register) 
*/


$('.auth-container h1 span').click(function(){

  $(this).addClass('active').siblings().removeClass('active');

  $('.auth-container form').hide()

  $("." + $(this).data('class')).fadeIn(100)

})






// make Live Preview in form

// First Way mark here

// $('.livename').keyup(function () {
  
//   $('.live-preview .preview-title').text($(this).val())

// })
// $('.liveDesctiption').keyup(function () {
  
//   $('.live-preview .preview-description').text($(this).val())

// })
// $('.livePrice').keyup(function () {
  
//   $('.live-preview .preview-price').text("$" + $(this).val())

// })

// Secound Way mark here

$('.live').keyup(function () {
  
  $($(this).data('class')).text($(this).val())

})


});