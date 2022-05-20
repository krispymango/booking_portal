<?php
include 'path.php';
include ROOT_PATH . '/apps/database/connection.php';
if (!isset($_SESSION['id']))
{
  header('location:'.BASE_URL);
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
    <!-- GC-Calendar Plugin Files -->
    <link rel="stylesheet" href="assets/css/calendar-gc.css" />
    <script src="assets/js/calendar-gc.js"></script>

  </head>
  <body>

    <div class="main_body">

      <!--header-->
      <?php
      include(ROOT_PATH . '/apps/includes/header.php');
       ?>
      <!--header-->

      <div class="dashboard_pane">

      <!--dashboard-->
        <?php
        include(ROOT_PATH . '/apps/includes/navigation.php');
         ?>
      <!--dashboard-->

      <div class="right_pane">

      <div class="right_pane_heading">
        <h1>Dashboard<span> - View your reservations</span></h1>
      </div>

      <div class="right_pane_body">

        <div class="dashboard_grid">

          <div class="dashboard_left_grid">
            <h3 class="recently_booked_heading">Calendar</h3>
            <div class="event_calendar">
              <div id="calendar"></div>
            </div>


          </div>

          <div class="dashboard_right_grid">

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
<?php
$manage_event_sql = "SELECT * FROM event LIMIT 3";
$manage_event_sql_execute = mysqli_query($conn,$manage_event_sql);
$id = 1;

echo "<h3 class='recently_booked_heading'>Recently Booked Events</h3>";
while ($manage_event_sql_fetch = mysqli_fetch_assoc($manage_event_sql_execute))
{

  if ($manage_event_sql_fetch['people'] == null)
  {
    $manage_event_sql_fetch['people'] = 0;
  }
  echo "
  <a class='booking_container_two'>
    <div class='booking_date'>
      <div class='booking_calendar_container'>
        <div class='calendar_month'>
          <h5>".date('M', strtotime($manage_event_sql_fetch['event_month']))."</h5>
        </div>
        <div class='calendar_date'>
          <span>".$manage_event_sql_fetch['event_day']."</span>
        </div>
      </div>
    </div>
    <div class='booking_details'>
      <h3>".$manage_event_sql_fetch['name']."</h3>
      <div class='booking_details_info_two'>
        <h4><i class='fas fa-map-marker-alt'></i> ".$manage_event_sql_fetch['venue']."</h4>
        <h4><i class='fas fa-clock'></i> ".date('h:i:a', strtotime($manage_event_sql_fetch['event_time']))."</h4>
      </div>
    </div>
  </a>
  ";
}
 ?>
<?php endif; ?>



<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
<?php
$manage_event_sql = "SELECT
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
	LEFT JOIN `user` u ON r.user_id = u.id  WHERE user_id = '$_SESSION[id]'";
$manage_event_sql_execute = mysqli_query($conn,$manage_event_sql);
$id = 1;

echo "<h3 class='recently_booked_heading'>Recent Reservations</h3>";
while ($manage_event_sql_fetch = mysqli_fetch_assoc($manage_event_sql_execute))
{

  if ($manage_event_sql_fetch['people'] == null)
  {
    $manage_event_sql_fetch['people'] = 0;
  }
  echo "
  <a class='booking_container_two'>
    <div class='booking_date'>
      <div class='booking_calendar_container'>
        <div class='calendar_month'>
          <h5>".date('M', strtotime($manage_event_sql_fetch['event_month']))."</h5>
        </div>
        <div class='calendar_date'>
          <span>".$manage_event_sql_fetch['event_day']."</span>
        </div>
      </div>
    </div>
    <div class='booking_details'>
      <h3>".$manage_event_sql_fetch['name']."</h3>
      <div class='booking_details_info_two'>
        <h4><i class='fas fa-map-marker-alt'></i> ".$manage_event_sql_fetch['venue']."</h4>
        <h4><i class='fas fa-clock'></i> ".date('h:i:a', strtotime($manage_event_sql_fetch['event_time']))."</h4>
      </div>
    </div>
  </a>
  ";
}
 ?>
<?php endif; ?>
          </div>

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

      <script>
        $(function (e) {
          var calendar = $("#calendar").calendarGC({
            dayBegin: 0,
            prevIcon: '&#x3c;',
            nextIcon: '&#x3e;',
            events: [
              <?php
              $calendar_event_sql = "SELECT
	e.id AS event_id,
	r.id AS reservation_id,
	u.id AS user_id,
	e.name,
	e.venue,
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
	LEFT JOIN `user` u ON r.user_id = u.id ";
              $calendar_event_sql_execute = mysqli_query($conn,$calendar_event_sql);

              while ($calendar_event_sql_fetch = mysqli_fetch_assoc($calendar_event_sql_execute))
              {
                echo "{
                  date: new Date('".$calendar_event_sql_fetch['event_year']."-".$calendar_event_sql_fetch['event_month']."-".$calendar_event_sql_fetch['event_day']."'),
                  eventName: '".$calendar_event_sql_fetch['name']."',
                  className: 'badge bg-danger',
                  onclick(e, data) {
                    //console.log(data);
                  },
                  dateColor: 'red'
                },";
              }
               ?>
            ]
          });
        })
      </script>
  </body>
</html>
