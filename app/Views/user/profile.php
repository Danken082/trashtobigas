<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="<?= base_url('css/user/profile.css')?>">
  <title>Client Profile</title>
</head>
<body>

<?php include('include/header.php');?>
  <div class="container">
    <div class="profile-header">
      <img src="https://via.placeholder.com/80" alt="User Image">
      <div>
        <h2>Juan Dela Cruz</h2>
        <p>Member since: January 2023</p>
      </div>
    </div>

    <div class="profile-details">
      <p><strong>Email:</strong> juan.delacruz@email.com</p>
      <p><strong>Phone:</strong> +63 912 345 6789</p>
      <p><strong>Address:</strong> Brgy. Ilaya, Calapan City</p>
      <p><strong>Points:</strong> 350</p>
    </div>


    
  <div class="change-password">
  <h3 style="margin-top: 2rem;">Change Password</h3>
  <form action="update_password.php" method="POST" style="margin-top: 1rem;">
    <div style="margin-bottom: 1rem;">
      <label for="current_password"><strong>Current Password:</strong></label><br>
      <input type="password" id="current_password" name="current_password" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <div style="margin-bottom: 1rem;">
      <label for="new_password"><strong>New Password:</strong></label><br>
      <input type="password" id="new_password" name="new_password" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <div style="margin-bottom: 1.5rem;">
      <label for="confirm_password"><strong>Confirm New Password:</strong></label><br>
      <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Update Password</button>
  </form>
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
