<?php
include 'path.php';
include 'apps/controllers/admin_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';
if (isset($_GET['id']))
{
  $event_id = base64_decode($_GET['id']);
  $select_event_sql = "SELECT * FROM event WHERE id = '$event_id'";
  $select_event_execute = mysqli_query($conn,$select_event_sql);

  if ($select_event_execute && ($select_event_fetch = mysqli_fetch_assoc($select_event_execute)))
  {
    $evnt_id = $select_event_fetch['id'];
    $evnt_name = $select_event_fetch['name'];
    $vnue = $select_event_fetch['venue'];
    $capcty = $select_event_fetch['capacity'];
    $dat = $select_event_fetch['event_year']."-".$select_event_fetch['event_month']."-".$select_event_fetch['event_day'];
    $tim = $select_event_fetch['event_time'];
  }
}

if (isset($_POST['edit_event']))
{
  $event_id = $_POST['event_id'];
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


  $edit_vent_sql = "UPDATE event SET name = '$event_name',venue = '$venue',capacity = '$capacity',event_day = '$day' ,event_month = '$month' ,event_year = '$year',event_time = '$time' WHERE id = '$event_id'";
  $edit_vent_execute = mysqli_query($conn,$edit_vent_sql);

  if ($edit_vent_execute)
  {
    $_SESSION['msg'] = "<div class='success_msg'><h4><i class='fas fa-exclamation'></i> User updated sucessfully</h4></div>";
    header('location:'.BASE_URL.'/manage_event.php');
  }
  else
  {
    header('location:'.BASE_URL.'/edit_event.php?id='.base64_decode($event_id));
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i> Could not edit user</h4></div>";
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Event | Event Booking System</title>
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
            <h1>Update event<span> - make edits to an event</span></h1>
          </div>

          <div class="right_pane_body">

            <div class="">
              <form class="signup_form_two" action="<?php echo BASE_URL . '/edit_event.php'; ?>" method="post">
                <h4>Name of event:</h4>
                <input type="hidden" name="event_id" value="<?php echo $evnt_id; ?>">
                <input type="text" name="event_name" value="<?php echo $evnt_name; ?>">
                <h4>Venue:</h4>
                <input type="text" name="venue" value="<?php echo $vnue; ?>">
                <div style="display:grid; grid-template-columns:repeat(3,1fr); grid-column-gap:10px; grid-row-gap:5px;">
                  <h4>Capacity:</h4>
                  <h4>Date:</h4>
                  <h4>Time:</h4>
                  <input type="number" name="capacity" value="<?php echo $capcty; ?>">
                  <input type="text" name="date" value="<?php echo $dat; ?>">
                  <input type="time" name="time" value="<?php echo $tim; ?>">
                </div>
                <input type="submit" name="edit_event" value="Update">
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
