<?php
include 'path.php';
include 'apps/controllers/admin_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';
if (isset($_GET['id']))
{
  $u_id = base64_decode($_GET['id']);
  $select_event_sql = "SELECT * FROM user WHERE id = '$u_id'";
  $select_event_execute = mysqli_query($conn,$select_event_sql);

  if ($select_event_execute && ($select_event_fetch = mysqli_fetch_assoc($select_event_execute)))
  {
    $name = $select_event_fetch['fullname'];
    $email = $select_event_fetch['email'];
    $role = $select_event_fetch['role'];
  }
}

if (isset($_POST['edit_user']))
{
  $idd = stripcslashes(base64_decode($_POST['user_id']));
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





  $create_user_sql = "UPDATE user SET fullname = '$fullname',email = '$email',password = '$hashedPassword',role = '$role' WHERE id = '$idd'";
  $create_user_execute = mysqli_query($conn,$create_user_sql);

  if ($create_user_execute)
  {
    header('location:'.BASE_URL.'/manage_user.php');
  }
  else
  {
    header('location:'.BASE_URL.'/edit_user.php?id='.base64_decode($user_id));
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
            <h1>Update User<span> - edit a user's details</span></h1>
          </div>

          <div class="right_pane_body">

            <div class="">
              <form class="signup_form_two" action="edit_user.php" method="post">
                <h4>Fullname:</h4>
                <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
                <input type="text" name="fullname" value='<?php echo $name; ?>' autocomplete>
                <h4>Email:</h4>
                <input type="text" name="email" value='<?php echo $email; ?>' autocomplete>
                <h4>Role:</h4>
                <select class=""  name="role">
                  <option value="<?php echo ($role>1) ? 'user' : 'Organizer'; ?>"><?php echo ($role>1) ? 'user' : 'Organizer'; ?></option>
                  <option value="1">Organizer</option>
                  <option value="2">User</option>
                </select>
                <h4>Password:</h4>
                <div class="password_wrapper">
                <input id="sgn_psswrd" type="password" name="password" autocomplete>
                <span id="sgn_pswd_btn"><i class="fas fa-eye"></i></span>
              </div>
                <h4>Confirm Password:</h4>
                <div class="password_wrapper">
                <input id="sgn_conf_psswrd" type="password" name="password_confirm" autocomplete>
                <span id="sgn_conf_pswd_btn"><i class="fas fa-eye"></i></span>
              </div>
                <input type="submit" name="edit_user" value="Update">
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
