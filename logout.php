<?php
include 'path.php';
include ROOT_PATH . '/apps/database/connection.php';

session_destroy();
header('location:'.BASE_URL);


 ?>
