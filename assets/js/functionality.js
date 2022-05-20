window.onload = function()
{
  let change_sign_password = false;
  let change_sign_password_conf = false;
  let change_login_password = false;
  let change_login_password_conf = false;

  document.getElementById('signin_btn').addEventListener('click',showSignupForm);
  document.getElementById('signup_btn').addEventListener('click',showLoginForm);
  document.getElementById('lgn_pswd_btn').addEventListener('click',loginPasswordShow);
  //document.getElementById('lgn_conf_pswd_btn').addEventListener('click',loginPasswordConfShow);
  document.getElementById('sgn_pswd_btn').addEventListener('click',signupPasswordShow);
  document.getElementById('sgn_conf_pswd_btn').addEventListener('click',signupPasswordConfShow);

  function showSignupForm()
  {
    document.querySelector('.login_form').style.display = 'none';
    document.querySelector('.signup_form').style.display = 'block';
    document.querySelector('#error_message').style.display = 'none';
  }

  function showLoginForm()
  {
    document.querySelector('.login_form').style.display = 'block';
    document.querySelector('.signup_form').style.display = 'none';
    document.querySelector('#error_message').style.display = 'none';
  }

  function signupPasswordShow()
  {
  if (change_sign_password === false)
  {
  document.querySelector('#sgn_psswrd').setAttribute("type","text");
  change_sign_password = true;
  }
  else if (change_sign_password === true)
  {
  document.querySelector('#sgn_psswrd').setAttribute("type","password");
  change_sign_password = false;
  }
  }

  function signupPasswordConfShow()
  {
  if (change_sign_password_conf === false)
  {
  document.querySelector('#sgn_conf_psswrd').setAttribute("type","text");
  change_sign_password_conf = true;
  }
  else if (change_sign_password_conf === true)
  {
  document.querySelector('#sgn_conf_psswrd').setAttribute("type","password");
  change_sign_password_conf = false;
  }
  }


  function loginPasswordShow()
  {
  if (change_login_password === false)
  {
  document.querySelector('#lgn_psswrd').setAttribute("type","text");
  change_login_password = true;
  }
  else if (change_login_password === true)
  {
  document.querySelector('#lgn_psswrd').setAttribute("type","password");
  change_login_password = false;
  }
  }


  function loginPasswordConfShow()
  {
  if (change_login_password_conf === false)
  {
  document.querySelector('#lgn_conf_psswrd').setAttribute("type","text");
  change_login_password_conf = true;
  }
  else if (change_login_password_conf === true)
  {
  document.querySelector('#lgn_conf_psswrd').setAttribute("type","password");
  change_login_password_conf = false;
  }
  }

};
