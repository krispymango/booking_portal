<?php
include 'path.php';
include 'apps/controllers/user_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';

if (isset($_POST['create_reservation']))
{
  $rsv_id = stripcslashes($_POST['event_id']);
  $rsv_u_id = stripcslashes($_POST['user_id']);
  $rsv_fullname = stripcslashes($_POST['user_fullname']);
  $rsv_email = stripcslashes($_POST['user_email']);
  $rsv_people = stripcslashes($_POST['people']);
  $rsv_date = stripcslashes($_POST['d_date']);
  $rsv_time = stripcslashes($_POST['t_time']);
         /* stripcslashes */



         /* mysqli real escape string(prevent sql injection) */
  $rsv_id = mysqli_real_escape_string($conn,$rsv_id);
  $rsv_u_id = mysqli_real_escape_string($conn,$rsv_u_id);
  $rsv_fullname = mysqli_real_escape_string($conn,$rsv_fullname);
  $rsv_email = mysqli_real_escape_string($conn,$rsv_email);
  $rsv_people = mysqli_real_escape_string($conn,$rsv_people);
  $rsv_date = mysqli_real_escape_string($conn,$rsv_date);
  $rsv_time = mysqli_real_escape_string($conn,$rsv_time);




  $create_rsv_sql = "INSERT INTO reservations(event_id,user_id,people,fullname,email) VALUES('$rsv_id','$rsv_u_id','$rsv_people','$rsv_fullname','$rsv_email')";
  $create_rsv_execute = mysqli_query($conn,$create_rsv_sql);
  if ($create_rsv_execute)
  {
    header('location:'.BASE_URL.'/booked_event.php');
  }
  else
  {
    header("location:".BASE_URL."/create_reservation.php?event_id=".base64_encode($rsv_id)."&u_id=".base64_encode($rsv_u_id));
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> Could not create user</h4></div>";
  }

}

if (isset($_GET['event_id']) && isset($_GET['u_id']))
{
  $evnt_id = base64_decode($_GET['event_id']);
  $u_id = base64_decode($_GET['u_id']);
  $select_event_sql = "SELECT * FROM event WHERE id = '$evnt_id'";
  $select_event_execute = mysqli_query($conn,$select_event_sql);

  if ($select_event_execute && ($select_event_fetch = mysqli_fetch_assoc($select_event_execute)))
  {
    $event_name = $select_event_fetch['name'];
    $date = $select_event_fetch['event_year'] . '-' . $select_event_fetch['event_month'] . '-' . $select_event_fetch['event_day'] ;
    $time = $select_event_fetch['event_time'];
    $capacity = $select_event_fetch['capacity'];
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create reservation | Event Booking System</title>
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
      <div id="error_message">

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
            <h1>Book Reservation<span> - book a reservation</span></h1>
          </div>

          <div class="right_pane_body">

            <div class="">
              <form class="signup_form_two" action='<?php echo BASE_URL . "/create_reservation.php"; ?>' method="post">

                <input type="hidden" name="event_id" value="<?php echo isset($evnt_id) ? $evnt_id : null ; ?>">

                <input type="hidden" name="user_id" value="<?php echo isset($u_id) ? $u_id : null ; ?>">
                <h4>Event name:</h4>
                <input type="text" disabled value="<?php echo $event_name; ?>">
                <h4>Fullname:</h4>
                <input type="text" name="user_fullname">
                <h4>Email:</h4>
                <input type="email" name="user_email" >
                <div style="display:grid; grid-template-columns:repeat(3,1fr); grid-column-gap:10px; grid-row-gap:5px;">
                  <h4>No. of people:</h4>
                  <h4>Date:</h4>
                  <h4>Time:</h4>
                  <select name="people" required>
                    <?php
                    if (isset($capacity))
                    {

                      echo "<option value=''>0</option>";
                      for ($i=1; $i <= $capacity ; $i++)
                      {
                        echo "<option value='".$i."'>".$i."</option>";
                      }
                    }
                    else
                    {
                      echo "<option value=''>0</option>";
                    }
                    ?>
                  </select>
                  <input type="text" disabled name="d_date" value="<?php echo isset($date) ? $date : null ; ?>">
                  <input type="text" disabled name="t_time" value="<?php echo isset($time) ? $time : null ; ?>">
                </div>
                <input type="submit" name="create_reservation" value="Book Reservation">
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
