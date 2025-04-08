<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="<?= base_url('css/user/home.css')?>">
  <title>Client Home</title>
</head>
<body>

<?php include('include/header.php');?>

  <div class="container">
  <h2>Points History</h2>
  <div class="history">
    <div class="history-item">
      <strong>March 25, 2025</strong><br>
      Redeemed 100 points for discount. <br>
      <small>Redeemed at barangay Ilaya</small>
    </div>
    <div class="history-item">
      <strong>March 10, 2025</strong><br>
      Redeemed 50 points for a free item.
    </div>
    <div class="history-item">
      <strong>February 28, 2025</strong><br>
      Redeemed 150 points for a voucher.
    </div>
  </div>
</div>

  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    }
  </script>

</body>
</html>
