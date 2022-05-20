<?php
include 'path.php';
include 'apps/controllers/logged_user.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/functionality.js"></script>
    <script src="assets/js/authentication.js"></script>
  </head>
  <body>

    <div class="main_body">

      <div id="error_message">
      </div>

      <!-- Form Container --->
      <div class="form_container">

        <!-- Login Form Container --->
        <form class="login_form" action="#" method="post">
          <h2>Sign In</h2>
          <h4>Email:</h4>
          <div class="password_wrapper">
            <input id="lgn_eml" type="email" name="login_email" autocomplete required>
            <div class="span"></div>
          </div>
          <h4>Password:</h4>
          <div class="password_wrapper">
            <input id="lgn_psswrd" type="password" name="login_password" required>
            <span id="lgn_pswd_btn"><i class="fas fa-eye"></i></span>
          </div>
          <!--
          <h4>Confirm Password:</h4>
          <div class="password_wrapper">
            <input id="lgn_conf_psswrd" type="password" name="login_password_confirm" required>
            <span id="lgn_conf_pswd_btn"><i class="fas fa-eye"></i></span>
          </div>
        -->
          <input id="lgn_sbmt_btn" type="submit" name="login_submit" value="Sign In">
          <h4 id="signin_btn" class='sign_or_signup_btn'>Click here to Signup!</h4>
        </form>
        <!-- Login Form Container --->


          <!-- Signup Form Container --->
        <form class="signup_form" action="index.html" method="post">
          <h2>Signup</h2>
          <h4>Fullname</h4>
          <div class="password_wrapper">
          <input id="sgn_fullname" type="text" autocomplete name="signup_fullname" required>
          <div class="span"></div>
        </div>
          <h4>Email:</h4>
          <div class="password_wrapper">
            <input id="sgn_eml" type="email" autocomplete name="signup_email" required>
            <div class="span"></div>
          </div>
          <h4>Password:</h4>
          <div class="password_wrapper">
            <input id="sgn_psswrd" type="password" name="signup_password" required>
            <span id="sgn_pswd_btn"><i class="fas fa-eye"></i></span>
          </div>
          <h4>Confirm Password:</h4>
          <div class="password_wrapper">
            <input id="sgn_conf_psswrd" type="password" name="signup_password_confirm" required>
            <span id="sgn_conf_pswd_btn"><i class="fas fa-eye"></i></span>
          </div>
          <input id="sgn_sbmt_btn" type="submit" name="signup_submit" value="Sign Up">
          <h4 id="signup_btn" class='sign_or_signup_btn'>Click here to SigIn!</h4>
        </form>
        <!-- Signup Form Container --->

        <div class="form_display">
          <h1>Booking Portal</h1>
        </div>

      </div>
      <!-- Form Container --->


    </div>

  </body>
</html>
