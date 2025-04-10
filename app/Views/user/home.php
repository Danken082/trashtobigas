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
  <h2>Welcome Client: <?= session()->get('idNumber')?></h2>
  <h3>Click The Profile Menu For more</h3>
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
