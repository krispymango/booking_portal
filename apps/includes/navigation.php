<div class="left_pane">
  <ul>
    <li></li>
    <a href="<?php echo BASE_URL . '/dashboard.php' ;?>"><li><i class="fas fa-lg fa-house-user"></i> <span class="navigation_popup">Dashboard</span></li></a>
    <?php if (($_SESSION['role']) == 2): ?>
      <a href="<?php echo BASE_URL . '/events.php'; ?>"><li><i class="fas fa-lg fa-glass-cheers"></i> <span class="navigation_popup">Events</span> </li></a>
      <a href="<?php echo BASE_URL . '/booked_event.php'; ?>"><li><i class="fas fa-lg fa-book-open"></i> <span class="navigation_popup"> Booked Events</span></li></a>
    <?php else : ?>
      <a href="<?php echo BASE_URL . '/manage_event.php'; ?>"><li><i class="fas fa-lg fa-calendar-alt"></i> <span class="navigation_popup">Manage Events</span></li></a>
      <a href="<?php echo BASE_URL . '/manage_user.php'; ?>"><li><i class="fas fa-lg fa-users-cog"></i> <span class="navigation_popup">Manage Users</span></li></a>
    <?php endif; ?>

  </ul>
</div>
