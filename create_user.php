<?php
include 'path.php';
include 'apps/controllers/admin_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';

if (isset($_POST['create_user']))
{
  $fullname = stripcslashes($_POST['fullname']);
  $email = stripcslashes($_POST['email']);
  $password = stripcslashes($_POST['password']);
  $password_confirm = stripcslashes($_POST['password_confirm']);
  $role = stripcslashes($_POST['role']);
         /* stripcslashes */



         /* mysqli real escape string(prevent sql injection) */
  $fullname = mysqli_real_escape_string($conn,$fullname);
  $email = mysqli_real_escape_string($conn,$email);
  $password = mysqli_real_escape_string($conn,$password);
  $password_confirm = mysqli_real_escape_string($conn,$password_confirm);
  $role = mysqli_real_escape_string($conn,$role);
  $hashedPassword = password_hash($password,PASSWORD_DEFAULT);




  $create_user_sql = "INSERT INTO user(fullname,email,password,role) VALUES('$fullname','$email','$hashedPassword','$role')";
  $create_user_execute = mysqli_query($conn,$create_user_sql);

  if ($create_user_execute)
  {
    header('location:'.BASE_URL.'/manage_user.php');
  }
  else
  {
    header('location:'.BASE_URL.'/create_user.php');
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> Could not create user</h4></div>";
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create user | Event Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/functionality.js"></script>
  </head>
  <body>

    <div class="main_body">
      <div id="error_message">
        <?php if (isset($_SESSION['msg'])): ?>
          <script type="text/javascript">
          $(document).ready(function()
          {
            $('#error_message').show();
          });
          </script>
          <?php
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
          ?>
        <?php endif; ?>
      </div>



      <?php
      include(ROOT_PATH . '/apps/includes/header.php');
       ?>

      <div class="dashboard_pane">
        <?php
        include(ROOT_PATH . '/apps/includes/navigation.php');
         ?>
        <div class="right_pane">
          <div class="right_pane_heading">
            <h1>Create User<span> - create a user</span></h1>
          </div>

          <div class="right_pane_body">

            <div class="">
              <form class="signup_form_two" action="create_user.php" method="post">
                <h4>Fullname:</h4>
                <input type="text" name="fullname" autocomplete>
                <h4>Email:</h4>
                <input type="text" name="email" autocomplete>
                <h4>Role:</h4>
                <select class="" name="role">
                  <option value="1">Organizer</option>
                  <option value="2">User</option>
                </select>
                <h4>Password:</h4>
                <div class="password_wrapper">
                <input type="password" name="password" autocomplete>
                <span><i class="fas fa-eye"></i></span>
              </div>
                <h4>Confirm Password:</h4>
                <div class="password_wrapper">
                <input type="password" name="password_confirm" autocomplete>
                <span><i class="fas fa-eye"></i></span>
              </div>
                <input type="submit" name="create_user" value="Create">
              </form>
            </div>

          </div>
          <!--Footer -->
          <?php
          include(ROOT_PATH . '/apps/includes/footer.php');
          ?>
          <!--Footer -->

        </div>

      </div>

    </div>

  </body>
</html>
