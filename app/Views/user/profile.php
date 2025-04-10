<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="<?= base_url('css/user/profile.css')?>">
  <title>Client Profile</title>
</head>

<style>
  .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-overlay.active {
  display: flex;
}

.modal-box {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  max-width: 300px;
  width: 90%;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  position: relative;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 16px;
  font-size: 24px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}

.flash-message {
  padding: 1rem 1.5rem;
  border-radius: 8px;
  margin: 1rem 0;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  animation: slideIn 0.4s ease;
}

.flash-message.success {
  background-color: #e6ffed;
  color: #207a43;
  border-left: 6px solid #34d399;
}

.flash-message.error {
  background-color: #ffe6e6;
  color: #a33a3a;
  border-left: 6px solid #f87171;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


</style>
<body>

<?php include('include/header.php');?>
  <div class="container">
   <!-- Profile Header with image -->
<div class="profile-header">
<img src="<?= base_url('/images/client/') . session()->get('img') ?>" 
     alt="User Image" 
     class="clickable-profile-img" 
     style="cursor: pointer;" 
     onclick="openImageModal()">

  <div>
    <h2><?= session()->get('firstName') . ' ' . session()->get('lastName') ?></h2>
    <p>Member since: <?= date('F j, Y', session()->get('created_at')) ?></p>
  </div>
</div>


    <div class="profile-details">
      <p><strong>Email:</strong> <?= session()->get('email')?></p>
      <p><strong>Phone:</strong><?= session()->get('contactNo')?></p>
      <p><strong>Address:</strong><?= session()->get('address')?></p>
      <p><strong>Points:</strong> <?= number_format(session()->get('totalPoints'),2 )?></p>

    </div>


    
  <div class="change-password">
  <?php if (session()->getFlashdata('error')): ?>
  <div class="flash-message error">
    <i class="fa fa-times-circle"></i>
    <?= session()->getFlashdata('error') ?>
  </div>

<?php elseif(session()->getFlashdata('msg')): ?>
  <div class="flash-message success">
    <i class="fa fa-check-circle"></i>
    <?= session()->getFlashdata('msg') ?>
  </div>
<?php endif; ?>

        <p></p>
      <h3 style="margin-top: 2rem;">Change Password</h3>
  <form action="<?= base_url('/changepasswordprofile/')?>" method="POST" style="margin-top: 1rem;">
    <div style="margin-bottom: 1rem;">
      <label for="current_password"><strong>Current Password:</strong></label><br>
      <input type="password" id="current_password" name="currentpassword"  required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <div style="margin-bottom: 1rem;">
      <label for="new_password"><strong>New Password:</strong></label><br>
      <input type="password" id="new_password" name="newpassword" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <div style="margin-bottom: 1.5rem;">
      <label for="confirm_password"><strong>Confirm New Password:</strong></label><br>
      <input type="password" id="confirm_password" name="confirmpassword" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; margin-top: 4px;">
    </div>
    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer;">Update Password</button>
  </form>
</div>

  </div>
  

  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
<!-- Profile Image Modal -->
<div id="imageModal" class="modal-overlay">
  <div class="modal-box">
    <span class="close-btn" onclick="closeImageModal()">&times;</span>
    <h4 style="margin-bottom: 1rem;">Edit Profile Image</h4>
<!--   
    <form id="imageForm" action="<?= base_url('uploadprofileimage') ?>" method="post" enctype="multipart/form-data">
      <img id="previewImg" src="<?= base_url('/images/client/') . session()->get('img') ?>" 
           alt="Preview" 
           style="width: 100%; height: auto; margin-bottom: 15px; border-radius: 10px; border: 1px solid #ccc;">

      <input type="file" name="profile_img" id="profile_img" accept="image/*" style="margin-bottom: 20px; width: 100%;">

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" onclick="closeImageModal()" style="padding: 8px 14px;">Cancel</button>
        <button type="submit" style="padding: 8px 14px; background-color: #2d6a4f; color: #fff; border: none; border-radius: 5px;">Save</button>
      </div>
    </form>
  </div> -->
</div>



  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    }


    function openImageModal() {
    document.getElementById('imageModal').classList.add('active');
  }

  function closeImageModal() {
    document.getElementById('imageModal').classList.remove('active');
    document.getElementById('profile_img').value = '';
  }

  function previewSelectedImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('previewImg').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

  // Optional: close when clicking outside modal box
  window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
      closeImageModal();
    }
  };
  </script>
</body>

</html>
