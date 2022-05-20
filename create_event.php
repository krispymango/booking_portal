<?php
include 'path.php';
include 'apps/controllers/admin_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';
if (isset($_POST['create_event']))
{
  $event_name = stripcslashes($_POST['event_name']);
  $venue = stripcslashes($_POST['venue']);
  $capacity = stripcslashes($_POST['capacity']);
  $date = stripcslashes($_POST['date']);
  $time = stripcslashes($_POST['time']);
         /* stripcslashes */



         /* mysqli real escape string(prevent sql injection) */
  $event_name = mysqli_real_escape_string($conn,$event_name);
  $venue = mysqli_real_escape_string($conn,$venue);
  $capacity = mysqli_real_escape_string($conn,$capacity);
  $date = mysqli_real_escape_string($conn,$date);
  $time = mysqli_real_escape_string($conn,$time);
  //die($date);
  preg_match('/([0-9a-zA-Z]+)-([0-9a-zA-Z]+)-([0-9a-zA-Z]+)/',$date, $preg_date);
  $day = $preg_date[3];
  $month = $preg_date[2];
  $year = $preg_date[1];


  $create_vent_sql = "INSERT INTO event(name,venue,capacity,event_day,event_month,event_year,event_time) VALUES('$event_name','$venue','$capacity','$day','$month','$year','$time')";
  $create_vent_execute = mysqli_query($conn,$create_vent_sql);

  if ($create_vent_execute)
  {
    header('location:'.BASE_URL.'/manage_event.php');
  }
  else
  {
    header('location:'.BASE_URL.'/create_event.php');
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> Could not create user</h4></div>";
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dashboard | Event Booking System</title>
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
            <h1>Book Event<span> - create an event</span></h1>
          </div>

          <div class="right_pane_body">

            <div class="">
              <form class="signup_form_two" action="<?php echo BASE_URL . '/create_event.php'; ?>" method="post">
                <h4>Name of event:</h4>
                <input type="text" name="event_name">
                <h4>Venue:</h4>
                <input type="text" name="venue">
                <div style="display:grid; grid-template-columns:repeat(3,1fr); grid-column-gap:10px; grid-row-gap:5px;">
                  <h4>Capacity:</h4>
                  <h4>Date:</h4>
                  <h4>Time:</h4>
                  <input type="number" name="capacity" value="">
                  <input type="date" name="date">
                  <input type="time" name="time">
                </div>
                <input type="submit" name="create_event" value="Create">
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
