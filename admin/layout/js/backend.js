$(document).ready(function () {
  $("[placeholder]")
    .focus(function () {
      $(this).attr("text-data", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("text-data"));
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
});
