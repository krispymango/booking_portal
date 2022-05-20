/* Login Dynamic Post*/

$(document).ready(function()
{
  $('.login_form').submit(function(event)
  {
    //  $('.loading_modal_wrapper').show();
  event.preventDefault();
  var email = $("#lgn_eml").val();
  var password = $("#lgn_psswrd").val();
  //var password_confirm = $("#lgn_conf_psswrd").val();
  var submit = $("#lgn_sbmt_btn").val();
  $('#error_message').load("apps/controllers/authentication.php",
 {
    login_email: email,
    login_password: password,
    //login_password_confirm: password_confirm,
    login_submit: submit
  });
});
});

/* Login Dynamic Post*/




/* Signup Dynamic Post*/

$(document).ready(function()
{
  $('.signup_form').submit(function(event)
  {
    //  $('.loading_modal_wrapper').show();
  event.preventDefault();
  var fullname = $("#sgn_fullname").val();
  var email = $("#sgn_eml").val();
  var password = $("#sgn_psswrd").val();
  var password_confirm = $("#sgn_conf_psswrd").val();
  var submit = $("#sgn_sbmt_btn").val();
  $('#error_message').load("index.php",
 {
    signup_fullname: email,
    signup_email: password,
    signup_password: password,
    signup_password_confirm: password_confirm,
    signup_submit: submit
  });
});
});

/* Signup Dynamic Post*/
