<?php
if (isset($_SESSION['id']))
{
  if (isset($_SESSION['role']) && ($_SESSION['role'] != 2))
  {
    header('location:'.BASE_URL);
  }
}
else
{
  header('location:'.BASE_URL);
}
 ?>
