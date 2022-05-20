<?php
include 'path.php';
include 'apps/database/connection.php';
include 'apps/controllers/user_authorization.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Booked Events | Event Booking System</title>
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
            <h1>Events Reserved <span>- Reservations you have made</span></h1>
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



            <div class="booking_wrapper">

              <?php

                   if (isset($_GET['pageno']))
                   {
                       $pageno = $_GET['pageno'];
                   } else {
                       $pageno = 1;
                   }
                   $no_of_records_per_page = 4;
                   $offset = ($pageno-1) * $no_of_records_per_page;

                   $total_pages_sql = "SELECT COUNT(*) FROM event";
                   $result = mysqli_query($conn,$total_pages_sql);
                   $total_rows = mysqli_fetch_array($result)[0];
                   $total_pages = ceil($total_rows / $no_of_records_per_page);

                   $sql = "SELECT
                   	e.id AS event_id,
                   	r.id AS reservation_id,
                   	u.id AS user_id,
                   	e.name,
                   	e.venue,
                     e.event_time,
                   	e.capacity,
                   	e.event_day,
                   	e.event_month,
                   	e.event_year,
                   	r.people,
                   	r.fullname,
                   	r.email
                   FROM
                   	reservations r
                   	LEFT JOIN `event` e ON r.event_id = e.id
                   	LEFT JOIN `user` u ON r.user_id = u.id  WHERE user_id = '$_SESSION[id]' LIMIT $offset, $no_of_records_per_page";
                   $res_data = mysqli_query($conn,$sql);
                   while($row = mysqli_fetch_array($res_data)){
                     if ($row['people'] == null)
                     {
                       $row['people'] = 0;
                     }
                    echo "
                    <div class='booking_container'>
                      <div class='booking_date'>
                        <div class='booking_calendar_container'>
                          <div class='calendar_month'>
                            <h5>".date('M', strtotime($row['event_month']))."</h5>
                          </div>
                          <div class='calendar_date'>
                            <span>".$row['event_day']."</span>
                          </div>
                        </div>
                      </div>
                      <div class='booking_details'>
                        <h3>Wedding Party</h3>
                        <div class='booking_details_info'>
                          <h4><i class='fas fa-user'></i> No. of People : ".$row['people']."</h4>
                          <h4><i class='fas fa-map-marker-alt'></i> ".$row['venue']."</h4>
                          <h4><i class='fas fa-clock'></i> ".date('h:i:a', strtotime($row['event_time']))."</h4>
                        </div>
                      </div>
                      <div class='booking_status'>
                      <div class='booking_action_btn'>
                      <a href='".BASE_URL."/apps/controllers/delete.php?id=".base64_encode($row['reservation_id'])."&booking=true'><i class='fas fa-trash-alt'></i></a>
                      </div>
                      </div>
                    </div>";
                   }
                   mysqli_close($conn);
               ?>
            </div>

            <div class="pagination_wrapper">
              <ul class="pagination">
                  <li><a href="?pageno=1">First</a></li>
                  <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                      <a href="<?php if($pageno <= 1){ echo '#'; } else { echo BASE_URL . "/events.php?pageno=".($pageno - 1); } ?>">Prev</a>
                  </li>
                  <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                      <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo BASE_URL . "/events.php?pageno=".($pageno + 1); } ?>">Next</a>
                  </li>
                  <li><a href="<?php echo BASE_URL . '/events.php'; ?>?pageno=<?php echo $total_pages; ?>">Last</a></li>
              </ul>
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
