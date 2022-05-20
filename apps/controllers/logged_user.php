<?php
if (isset($_SESSION['id']))
{
    header('location:'.BASE_URL.'/dashboard.php');
}
 ?>
