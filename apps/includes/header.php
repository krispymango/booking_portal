<div class="header">
  <div class="header_grid">
    <div>
      <h2>Web Booking Portal</h2>
    </div>
    <div>
      <a href="<?php echo BASE_URL.'/logout.php'; ?>"><i class="fas fa-user-circle"></i> <?php echo (isset($_SESSION['fullname'])) ? $_SESSION['fullname'] : null ; ?> | <span><i class="fas fa-lg fa-sign-out-alt"></i>Logout</span></a>
    </div>
  </div>
</div>
