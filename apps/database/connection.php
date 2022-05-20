<?php



$conn = new mysqli('localhost','root','','booking_portal');

if (!$conn)
{
die('Connection Failed' . $conn->connect_error);
}

 ?>
