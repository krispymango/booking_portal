<?php
include 'path.php';
include 'apps/controllers/admin_authorization.php';
include ROOT_PATH . '/apps/database/connection.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Manage User | Event Booking System</title>
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

      <?php
      include(ROOT_PATH . '/apps/includes/header.php');
       ?>

      <div class="dashboard_pane">
        <?php
        include(ROOT_PATH . '/apps/includes/navigation.php');
         ?>
        <div class="right_pane">
          <div class="right_pane_heading">
            <h1>Manage Users<span> - manage users</span></h1>
          </div>

          <div class="right_pane_body">
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



            <div class="create_event">
              <a href="<?php echo BASE_URL . '/create_user.php'; ?>"><i class="fas fa-user-plus"></i> Create User</a>
            </div>

            <div class="table_container">
              <table>
                <thead>
                  <th></th>
                  <th>Fullname</th>
                  <th>E-mail</th>
                  <th>Role</th>
                  <th colspan="2">action</th>
                </thead>
                <tbody>
                  <?php

                  $manage_user_sql = "SELECT * FROM user";
                  $manage_user_sql_execute = mysqli_query($conn,$manage_user_sql);
                  $id = 1;

                  while ($manage_user_sql_fetch = mysqli_fetch_assoc($manage_user_sql_execute))
                  {

                    if ($manage_user_sql_fetch['role'] == 1)
                    {
                      $manage_user_sql_fetch['role'] = 'Organizer';
                    }
                    else
                    {
                      $manage_user_sql_fetch['role'] = 'User';
                    }

                    echo "
                    <tr>
                      <td>".$id++."</td>
                      <td>".$manage_user_sql_fetch['fullname']."</td>
                      <td>".$manage_user_sql_fetch['email']."</td>
                      <td>".$manage_user_sql_fetch['role']."</td>
                      <td><a href='".BASE_URL."/edit_user.php?id=".base64_encode($manage_user_sql_fetch['id'])."&user=true'><i class='fas fa-edit'></i></a> <a href='".BASE_URL."/apps/controllers/delete.php?id=".base64_encode($manage_user_sql_fetch['id'])."&user=true'><i class='fas fa-trash-alt'></i></a></td>
                    </tr>
                    ";
                  }

                   ?>
                </tbody>
              </table>
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
