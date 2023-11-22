  // Toggle password visibility
  $("#show_password").on('click', function(){
    var passwordInput = $("#senha");
    var passwordField = passwordInput.attr('type');
    if(passwordField === 'password') {
        passwordInput.attr('type', 'text');
    } else {
        passwordInput.attr('type', 'password');
    }
});

// Toggle repeat password visibility
$("#show_repeat_password").on('click', function(){
    var repeatPasswordInput = $("#senha");
    var repeatPasswordField = repeatPasswordInput.attr('type');
    if(repeatPasswordField === 'password') {
        repeatPasswordInput.attr('type', 'text');
    } else {
        repeatPasswordInput.attr('type', 'password');
    }
});




