<?php
include '../../path.php';
include ROOT_PATH . '/apps/database/connection.php';

$id = base64_decode($_GET['id']);
if (isset($_GET['event']))
{
  $delete_sql = "DELETE FROM event WHERE id = '$id'";
  $delete_sql_execute = mysqli_query($conn,$delete_sql);
  if ($delete_sql_execute)
  {
    $_SESSION['msg'] = "<div class='success_msg'><h4><Event deleted succesfully</h4></div>";
    header('location:'.BASE_URL.'/manage_event.php');
  }
  else
  {
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i>Error could not delete event</h4></div>";
    header('location:'.BASE_URL.'/manage_event.php');
  }
}
elseif (isset($_GET['user']))
{
  $delete_sql = "DELETE FROM user WHERE id = '$id'";
  $delete_sql_execute = mysqli_query($conn,$delete_sql);
  if ($delete_sql_execute)
  {
    $_SESSION['msg'] = "<div class='success_msg'><h4>User deleted succesfully</h4></div>";
    header('location:'.BASE_URL.'/manage_user.php');
  }
  else
  {
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i>Error could not delete user</h4></div>";
    header('location:'.BASE_URL.'/manage_user.php');
  }
}
elseif (isset($_GET['booking']))
{
  $delete_sql = "DELETE FROM reservations WHERE id = '$id'";
  $delete_sql_execute = mysqli_query($conn,$delete_sql);
  if ($delete_sql_execute)
  {
    $_SESSION['msg'] = "<div class='success_msg'><h4>Reservation deleted succesfully</h4></div>";
    header('location:'.BASE_URL.'/booked_event.php');
  }
  else
  {
    $_SESSION['msg'] = "<div class='error_msg'><h4><i class='fas fa-exclamation'></i>Error could not make reservation</h4></div>";
    header('location:'.BASE_URL.'/booked_event.php');
  }
}
else
{
  header('location:'.BASE_URL.'/dashboard.php');
}

 ?>
