<?php
include '../../path.php';
include ROOT_PATH . '/apps/database/connection.php';

if (isset($_POST['login_submit']))
{

  $login_email = stripcslashes($_POST['login_email']);
  $login_email = mysqli_real_escape_string($conn,$login_email);
  $login_pswd = stripcslashes($_POST['login_password']);
  $login_pswd = mysqli_real_escape_string($conn,$login_pswd);

  $lgn_sql = "SELECT * FROM user WHERE email = '$login_email'";
  $lgn_sql_execute = mysqli_query($conn,$lgn_sql);
  //die($lgn_sql);



  if($lgn_sql_execute)
  {

  if (($lgn_sql_fetch = mysqli_fetch_assoc($lgn_sql_execute)) && (password_verify($login_pswd,$lgn_sql_fetch['password'])))
  {
  $_SESSION['id'] = $lgn_sql_fetch['id'];
  $_SESSION['fullname'] = $lgn_sql_fetch['fullname'];
  $_SESSION['email'] = $lgn_sql_fetch['email'];
  $_SESSION['role'] = $lgn_sql_fetch['role'];
  echo "<script>
  $(document).ready(function() {
    window.location.href = '".BASE_URL."/dashboard.php';
  });</script>";
  }

  else
  {
    echo "
    <script>
    $('#error_message').show();
    </script>
    ";
    echo $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> email and password are incorrect</h4></div>";
  }

  }
  else
  {
    echo "
    <script>
    $('#error_message').show();
    </script>
    ";
   echo $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> error Login in User</h4></div>";
  }

}

elseif (isset($_POST['signup_submit']))
{


  /* stripcslashes */
$signup_fullname = stripcslashes($_POST['signup_fullname']);
$signup_email = stripcslashes($_POST['signup_email']);
$signup_password = stripcslashes($_POST['signup_password']);
$signup_password_confirm = stripcslashes($_POST['signup_password_confirm']);
  /* stripcslashes */

  /* mysqli real escape string(prevent sql injection) */
$signup_fullname = mysqli_real_escape_string($conn,$signup_fullname);
$signup_email = mysqli_real_escape_string($conn,$signup_email);
$signup_password = mysqli_real_escape_string($conn,$signup_password);
$signup_password_confirm = mysqli_real_escape_string($conn,$signup_password_confirm);

  /* mysqli real escape string(prevent sql injection) */


$existing_user = ValidateSignup();

if ($signup_password != $signup_password_confirm)
{
echo "
<script>
$('.loading_modal_wrapper').hide();
</script>
";
echo "passwords do not match";
}
elseif ($existing_user == 1)
{
echo "
<script>
$('.loading_modal_wrapper').hide();
</script>
";
echo "User Already exist";
}

else
{
echo " ";
$hashedPassword = password_hash($signup_password,PASSWORD_DEFAULT);
$sgn_sql = "INSERT INTO user(fullname,email,password,role) VALUES('$signup_fullname','$signup_email','$hashedPassword',2)";
$sgn_sql_execute = mysqli_query($conn,$sgn_sql);

if ($sgn_sql_execute)
{
LoginSignup();
echo "<script> window.location.reload()</script>";
}
else
{
echo "**Error Could not Signup**";
}
}

}

function ValidateSignup()
{
global $conn;
/* stripcslashes */
$signup_fulnam = stripcslashes($_POST['signup_fullname']);
$signup_eml = stripcslashes($_POST['signup_email']);
$signup_paswrd = stripcslashes($_POST['signup_password']);
$signup_paswrd_confirm = stripcslashes($_POST['signup_password_confirm']);
/* stripcslashes */



/* mysqli real escape string(prevent sql injection) */
$signup_fulnam = mysqli_real_escape_string($conn,$signup_fulnam);
$signup_eml = mysqli_real_escape_string($conn,$signup_eml);
$signup_paswrd = mysqli_real_escape_string($conn,$signup_paswrd);
$signup_paswrd_confirm = mysqli_real_escape_string($conn,$signup_paswrd_confirm);
//echo $phone_no;
$sgn_sql_select = "SELECT * FROM user WHERE email = '$signup_eml' AND fullname = '$signup_fulnam'";
$sgn_sql_execute_select = mysqli_query($conn,$sgn_sql_select);
$sgn_sql_fetch_select = mysqli_fetch_assoc($sgn_sql_execute_select);
$sgn_num_rows = mysqli_num_rows($sgn_sql_execute_select);
return $sgn_num_rows;
}

function LoginSignup()
{
global $conn;
/* stripcslashes */
$signup_fullnam = stripcslashes($_POST['signup_fullname']);
$signup_emal = stripcslashes($_POST['signup_email']);
$signup_passwrd = stripcslashes($_POST['signup_password']);
$signup_passwrd_confirm = stripcslashes($_POST['signup_password_confirm']);
/* stripcslashes */



/* mysqli real escape string(prevent sql injection) */
$signup_fullnam = mysqli_real_escape_string($conn,$signup_fullnam);
$signup_emal = mysqli_real_escape_string($conn,$signup_emal);
$signup_passwrd = mysqli_real_escape_string($conn,$signup_passwrd);
$signup_passwrd_confirm = mysqli_real_escape_string($conn,$signup_passwrd_confirm);

/* mysqli real escape string(prevent sql injection) */
//echo $phone_no;
$lgn_sgn_sql_select = "SELECT * FROM user WHERE email = '$signup_emal' AND fullname = '$signup_fullnam'";
$lgn_sgn_sql_execute_select = mysqli_query($conn,$lgn_sgn_sql_select);
$lgn_sgn_sql_fetch_select = mysqli_fetch_assoc($lgn_sgn_sql_execute_select);
$lgn_sgn_sql_num_rows_select = mysqli_num_rows($lgn_sgn_sql_execute_select);
if ($lgn_sgn_sql_num_rows_select > 0)
{
  $_SESSION['id'] = $lgn_sgn_sql_fetch_select['id'];
  $_SESSION['fullname'] = $lgn_sgn_sql_fetch_select['fullname'];
  $_SESSION['role'] = $lgn_sgn_sql_fetch_select['role'];
}
}



 ?>
